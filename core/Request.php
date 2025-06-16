<?php

class Request
{
    private static $instance = null;
    private $data = [];
    private $files = [];
    private $errors = [];
    private $rules = [];
    private $messages = [];

    public function __construct()
    {
        $this->data = array_merge($_GET, $_POST);
        $this->files = $_FILES;
    }

    /**
     * Get singleton instance
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get all input data
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Get specific input value
     */
    public function input($key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    /**
     * Get only specified keys
     */
    public function only($keys)
    {
        $result = [];
        foreach ($keys as $key) {
            if (isset($this->data[$key])) {
                $result[$key] = $this->data[$key];
            }
        }
        return $result;
    }

    /**
     * Get all except specified keys
     */
    public function except($keys)
    {
        $result = $this->data;
        foreach ($keys as $key) {
            unset($result[$key]);
        }
        return $result;
    }

    /**
     * Check if input has value
     */
    public function has($key)
    {
        return isset($this->data[$key]) && !empty($this->data[$key]);
    }

    /**
     * Check if input exists (even if empty)
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Get request method
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Check if request is POST
     */
    public function isPost()
    {
        return $this->method() === 'POST';
    }

    /**
     * Check if request is GET
     */
    public function isGet()
    {
        return $this->method() === 'GET';
    }

    /**
     * Check if request is AJAX
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Get uploaded file
     */
    public function file($key)
    {
        return isset($this->files[$key]) ? $this->files[$key] : null;
    }

    /**
     * Check if file was uploaded
     */
    public function hasFile($key)
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    /**
     * Validate request data
     */
    public function validate($rules, $messages = [])
    {
        $this->rules = $rules;
        $this->messages = $messages;
        $this->errors = [];

        foreach ($rules as $field => $ruleString) {
            $fieldRules = explode('|', $ruleString);
            $value = $this->input($field);

            foreach ($fieldRules as $rule) {
                $this->validateField($field, $value, $rule);
            }
        }

        if (!empty($this->errors)) {
            // Store errors in session for display
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['validation_errors'] = $this->errors;
            $_SESSION['old_input'] = $this->data;
            
            return false;
        }

        return true;
    }

    /**
     * Validate individual field
     */
    private function validateField($field, $value, $rule)
    {
        // Parse rule with parameters
        $ruleParts = explode(':', $rule);
        $ruleName = $ruleParts[0];
        $ruleParams = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];

        switch ($ruleName) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->addError($field, 'required');
                }
                break;

            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, 'email');
                }
                break;

            case 'min':
                $min = (int)$ruleParams[0];
                if (!empty($value) && strlen($value) < $min) {
                    $this->addError($field, 'min', ['min' => $min]);
                }
                break;

            case 'max':
                $max = (int)$ruleParams[0];
                if (!empty($value) && strlen($value) > $max) {
                    $this->addError($field, 'max', ['max' => $max]);
                }
                break;

            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, 'numeric');
                }
                break;

            case 'integer':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_INT)) {
                    $this->addError($field, 'integer');
                }
                break;

            case 'confirmed':
                $confirmField = $field . '_confirmation';
                if ($value !== $this->input($confirmField)) {
                    $this->addError($field, 'confirmed');
                }
                break;

            case 'unique':
                // Format: unique:table,column
                if (count($ruleParams) >= 2) {
                    $table = $ruleParams[0];
                    $column = $ruleParams[1];
                    if ($this->checkUnique($table, $column, $value)) {
                        $this->addError($field, 'unique');
                    }
                }
                break;

            case 'in':
                // Format: in:value1,value2,value3
                if (!empty($value) && !in_array($value, $ruleParams)) {
                    $this->addError($field, 'in', ['values' => implode(', ', $ruleParams)]);
                }
                break;

            case 'regex':
                // Format: regex:/pattern/
                if (!empty($value) && !preg_match($ruleParams[0], $value)) {
                    $this->addError($field, 'regex');
                }
                break;

            case 'file':
                if (!$this->hasFile($field)) {
                    $this->addError($field, 'file');
                }
                break;

            case 'image':
                if ($this->hasFile($field)) {
                    $file = $this->file($field);
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!in_array($file['type'], $allowedTypes)) {
                        $this->addError($field, 'image');
                    }
                }
                break;

            case 'mimes':
                // Format: mimes:jpg,png,pdf
                if ($this->hasFile($field)) {
                    $file = $this->file($field);
                    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    if (!in_array($extension, $ruleParams)) {
                        $this->addError($field, 'mimes', ['types' => implode(', ', $ruleParams)]);
                    }
                }
                break;

            case 'max_size':
                // Format: max_size:2048 (in KB)
                if ($this->hasFile($field)) {
                    $file = $this->file($field);
                    $maxSize = (int)$ruleParams[0] * 1024; // Convert KB to bytes
                    if ($file['size'] > $maxSize) {
                        $this->addError($field, 'max_size', ['size' => $ruleParams[0]]);
                    }
                }
                break;
        }
    }

    /**
     * Add validation error
     */
    private function addError($field, $rule, $params = [])
    {
        $message = $this->getErrorMessage($field, $rule, $params);
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    /**
     * Get error message
     */
    private function getErrorMessage($field, $rule, $params = [])
    {
        $customKey = $field . '.' . $rule;
        
        // Check for custom message
        if (isset($this->messages[$customKey])) {
            return $this->messages[$customKey];
        }

        // Default messages
        $defaultMessages = [
            'required' => 'Field :field wajib diisi.',
            'email' => 'Field :field harus berupa email yang valid.',
            'min' => 'Field :field minimal :min karakter.',
            'max' => 'Field :field maksimal :max karakter.',
            'numeric' => 'Field :field harus berupa angka.',
            'integer' => 'Field :field harus berupa bilangan bulat.',
            'confirmed' => 'Konfirmasi :field tidak cocok.',
            'unique' => 'Field :field sudah digunakan.',
            'in' => 'Field :field harus salah satu dari: :values.',
            'regex' => 'Format field :field tidak valid.',
            'file' => 'Field :field harus berupa file.',
            'image' => 'Field :field harus berupa gambar (jpg, png, gif, webp).',
            'mimes' => 'Field :field harus berupa file dengan tipe: :types.',
            'max_size' => 'Ukuran file :field maksimal :size KB.'
        ];

        $message = isset($defaultMessages[$rule]) ? $defaultMessages[$rule] : 'Field :field tidak valid.';
        
        // Replace placeholders
        $message = str_replace(':field', ucfirst(str_replace('_', ' ', $field)), $message);
        foreach ($params as $key => $value) {
            $message = str_replace(':' . $key, $value, $message);
        }

        return $message;
    }

    /**
     * Check if value is unique in database
     */
    private function checkUnique($table, $column, $value)
    {
        try {
            $config = require_once 'config/database.php';
            $pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['database']};charset=utf8",
                $config['username'],
                $config['password']
            );
            
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = ?");
            $stmt->execute([$value]);
            
            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get validation errors
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Get first error for field
     */
    public function error($field)
    {
        return isset($this->errors[$field]) ? $this->errors[$field][0] : null;
    }

    /**
     * Check if validation failed
     */
    public function fails()
    {
        return !empty($this->errors);
    }

    /**
     * Get old input value (for form repopulation)
     */
    public function old($key, $default = '')
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $oldInput = isset($_SESSION['old_input']) ? $_SESSION['old_input'] : [];
        return isset($oldInput[$key]) ? $oldInput[$key] : $default;
    }

    /**
     * Clear old input and errors from session
     */
    public static function clearOld()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION['old_input']);
        unset($_SESSION['validation_errors']);
    }

    /**
     * Get client IP address
     */
    public function ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Get user agent
     */
    public function userAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }

    /**
     * Get request URL
     */
    public function url()
    {
        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    }

    /**
     * Get full URL
     */
    public function fullUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        
        return $protocol . '://' . $host . $uri;
    }

    /**
     * Store file upload
     */
    public function storeFile($fieldName, $directory = 'uploads', $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf'])
    {
        if (!$this->hasFile($fieldName)) {
            return false;
        }

        $file = $this->file($fieldName);
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        // Check file type
        if (!in_array($extension, $allowedTypes)) {
            return false;
        }

        // Create directory if not exists
        $uploadPath = 'public/' . $directory;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $destination = $uploadPath . '/' . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $directory . '/' . $filename;
        }

        return false;
    }

    /**
     * Sanitize input
     */
    public function sanitize($key, $filter = FILTER_SANITIZE_STRING)
    {
        $value = $this->input($key);
        return $value ? filter_var($value, $filter) : null;
    }

    /**
     * Get request headers
     */
    public function header($key = null)
    {
        $headers = getallheaders();
        
        if ($key) {
            return isset($headers[$key]) ? $headers[$key] : null;
        }
        
        return $headers;
    }

    /**
     * Check if request expects JSON
     */
    public function expectsJson()
    {
        return $this->header('Accept') && 
               strpos($this->header('Accept'), 'application/json') !== false;
    }
}
