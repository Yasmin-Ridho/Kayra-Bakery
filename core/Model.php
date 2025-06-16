<?php

require_once 'core/Paginator.php';

class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = ['id'];
    protected $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    
    protected $attributes = [];
    protected $original = [];
    protected $exists = false;
    
    public function __construct($attributes = [])
    {
        $this->fillFromDatabase($attributes);
        
        // Set table name otomatis jika tidak didefinisikan
        if (!$this->table) {
            $className = get_class($this);
            $this->table = strtolower($className) . 's';
        }
    }
    
    /**
     * Fill model dengan attributes dari database (tidak terbatas fillable)
     */
    public function fillFromDatabase($attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }
    
    /**
     * Fill model dengan attributes (untuk mass assignment, terbatas fillable)
     */
    public function fill($attributes)
    {
        foreach ($attributes as $key => $value) {
            if ($this->isFillable($key)) {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }
    
    /**
     * Cek apakah attribute bisa diisi
     */
    protected function isFillable($key)
    {
        if (in_array($key, $this->guarded)) {
            return false;
        }
        
        if (empty($this->fillable)) {
            return true;
        }
        
        return in_array($key, $this->fillable);
    }
    
    /**
     * Get attribute value
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }
    
    /**
     * Set attribute value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
    
    /**
     * Get attribute
     */
    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }
    
    /**
     * Set attribute
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }
    
    /**
     * Save model ke database
     */
    public function save()
    {
        if ($this->exists) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }
    
    /**
     * Insert record baru
     */
    protected function insert()
    {
        $pdo = DB();
        
        if ($this->timestamps) {
            $now = date($this->dateFormat);
            $this->attributes['created_at'] = $now;
            $this->attributes['updated_at'] = $now;
        }
        
        $columns = array_keys($this->attributes);
        $placeholders = ':' . implode(', :', $columns);
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES ({$placeholders})";
        
        $stmt = $pdo->prepare($sql);
        
        foreach ($this->attributes as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        
        if ($stmt->execute()) {
            $this->attributes[$this->primaryKey] = $pdo->lastInsertId();
            $this->exists = true;
            $this->original = $this->attributes;
            return true;
        }
        
        return false;
    }
    
    /**
     * Update record yang sudah ada
     */
    protected function update()
    {
        $pdo = DB();
        
        if ($this->timestamps) {
            $this->attributes['updated_at'] = date($this->dateFormat);
        }
        
        $sets = [];
        foreach ($this->attributes as $key => $value) {
            if ($key !== $this->primaryKey) {
                $sets[] = "{$key} = :{$key}";
            }
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE {$this->primaryKey} = :{$this->primaryKey}";
        
        $stmt = $pdo->prepare($sql);
        
        foreach ($this->attributes as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        
        if ($stmt->execute()) {
            $this->original = $this->attributes;
            return true;
        }
        
        return false;
    }
    
    /**
     * Delete record
     */
    public function delete()
    {
        if (!$this->exists) {
            return false;
        }
        
        $pdo = DB();
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :{$this->primaryKey}";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':' . $this->primaryKey, $this->attributes[$this->primaryKey]);
        
        if ($stmt->execute()) {
            $this->exists = false;
            return true;
        }
        
        return false;
    }
    
    /**
     * Find record by ID
     */
    public static function find($id)
    {
        $instance = new static();
        $pdo = DB();
        
        $sql = "SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            $model = new static();
            $model->fillFromDatabase($data);
            $model->exists = true;
            $model->original = $data;
            return $model;
        }
        
        return null;
    }
    
    /**
     * Find record by column
     */
    public static function where($column, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $instance = new static();
        $pdo = DB();
        
        $sql = "SELECT * FROM {$instance->table} WHERE {$column} {$operator} :value";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        
        $results = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $model = new static();
            $model->fillFromDatabase($data);
            $model->exists = true;
            $model->original = $data;
            $results[] = $model;
        }
        
        return $results;
    }
    
    /**
     * Get all records
     */
    public static function all()
    {
        $instance = new static();
        $pdo = DB();
        
        $sql = "SELECT * FROM {$instance->table}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $results = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $model = new static();
            $model->fillFromDatabase($data);
            $model->exists = true;
            $model->original = $data;
            $results[] = $model;
        }
        
        return $results;
    }
    
    /**
     * Create new record
     */
    public static function create($attributes)
    {
        $model = new static();
        $model->fill($attributes);
        
        if ($model->save()) {
            return $model;
        }
        
        return false;
    }
    
    /**
     * Update record by ID
     */
    public static function updateById($id, $attributes)
    {
        $model = static::find($id);
        
        if (!$model) {
            return false;
        }
        
        $model->fill($attributes);
        return $model->save();
    }
    
    /**
     * Delete record by ID
     */
    public static function deleteById($id)
    {
        $model = static::find($id);
        
        if (!$model) {
            return false;
        }
        
        return $model->delete();
    }
    
    /**
     * Convert model to array
     */
    public function toArray()
    {
        return $this->attributes;
    }
    
    /**
     * Convert model to JSON
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
    
    /**
     * Check if model exists in database
     */
    public function exists()
    {
        return $this->exists;
    }
    
    /**
     * Get table name
     */
    public function getTable()
    {
        return $this->table;
    }
    
    /**
     * BelongsTo relationship (many-to-one)
     * Contoh: Product belongsTo Category
     */
    public function belongsTo($relatedModel, $foreignKey = null, $ownerKey = 'id')
    {
        // Auto-generate foreign key jika tidak disediakan
        if ($foreignKey === null) {
            $modelName = strtolower($this->class_basename($relatedModel));
            $foreignKey = $modelName . '_id';
        }
        
        $foreignKeyValue = $this->getAttribute($foreignKey);
        
        if ($foreignKeyValue) {
            return $relatedModel::find($foreignKeyValue);
        }
        
        return null;
    }
    
    /**
     * HasMany relationship (one-to-many)
     * Contoh: Category hasMany Products
     */
    public function hasMany($relatedModel, $foreignKey = null, $localKey = 'id')
    {
        // Auto-generate foreign key jika tidak disediakan
        if ($foreignKey === null) {
            $modelName = strtolower($this->class_basename(get_class($this)));
            $foreignKey = $modelName . '_id';
        }
        
        $localKeyValue = $this->getAttribute($localKey);
        
        if ($localKeyValue) {
            return $relatedModel::where($foreignKey, $localKeyValue);
        }
        
        return [];
    }
    
    /**
     * HasOne relationship (one-to-one)
     * Contoh: User hasOne Profile
     */
    public function hasOne($relatedModel, $foreignKey = null, $localKey = 'id')
    {
        // Auto-generate foreign key jika tidak disediakan
        if ($foreignKey === null) {
            $modelName = strtolower($this->class_basename(get_class($this)));
            $foreignKey = $modelName . '_id';
        }
        
        $localKeyValue = $this->getAttribute($localKey);
        
        if ($localKeyValue) {
            $results = $relatedModel::where($foreignKey, $localKeyValue);
            return !empty($results) ? $results[0] : null;
        }
        
        return null;
    }
    
    /**
     * Helper function untuk mendapatkan class name tanpa namespace
     */
    private function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
    
    /**
     * Paginate records
     */
    public static function paginate($perPage = 15, $page = null)
    {
        $instance = new static();
        $pdo = DB();
        
        // Get current page from URL parameter
        if ($page === null) {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        }
        
        $page = max(1, $page); // Ensure page is at least 1
        $offset = ($page - 1) * $perPage;
        
        // Get total count
        $countSql = "SELECT COUNT(*) FROM {$instance->table}";
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute();
        $total = $countStmt->fetchColumn();
        
        // Get paginated data
        $sql = "SELECT * FROM {$instance->table} ORDER BY {$instance->primaryKey} DESC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $model = new static();
            $model->fillFromDatabase($data);
            $model->exists = true;
            $model->original = $data;
            $results[] = $model;
        }
        
        // Create pagination object
        return new Paginator($results, $total, $perPage, $page);
    }
    
    /**
     * Get all records with ordering
     */
    public static function orderBy($column, $direction = 'ASC')
    {
        $instance = new static();
        $pdo = DB();
        
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        
        $sql = "SELECT * FROM {$instance->table} ORDER BY {$column} {$direction}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $results = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $model = new static();
            $model->fillFromDatabase($data);
            $model->exists = true;
            $model->original = $data;
            $results[] = $model;
        }
        
        return $results;
    }
}

?>
