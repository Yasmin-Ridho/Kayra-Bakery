<?php

/**
 * Paginator Class
 * 
 * Class untuk menangani pagination data dan generate pagination links
 * Mirip dengan Laravel Paginator
 */

class Paginator
{
    protected $items;
    protected $total;
    protected $perPage;
    protected $currentPage;
    protected $lastPage;
    protected $path;
    protected $query;

    public function __construct($items, $total, $perPage, $currentPage)
    {
        $this->items = $items;
        $this->total = $total;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->lastPage = (int) ceil($total / $perPage);
        $this->path = $this->getCurrentPath();
        $this->query = $this->getCurrentQuery();
    }

    /**
     * Get items
     */
    public function items()
    {
        return $this->items;
    }

    /**
     * Get total items
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * Get per page
     */
    public function perPage()
    {
        return $this->perPage;
    }

    /**
     * Get current page
     */
    public function currentPage()
    {
        return $this->currentPage;
    }

    /**
     * Get last page
     */
    public function lastPage()
    {
        return $this->lastPage;
    }

    /**
     * Check if there are more pages
     */
    public function hasPages()
    {
        return $this->lastPage > 1;
    }

    /**
     * Check if on first page
     */
    public function onFirstPage()
    {
        return $this->currentPage <= 1;
    }

    /**
     * Check if on last page
     */
    public function onLastPage()
    {
        return $this->currentPage >= $this->lastPage;
    }

    /**
     * Get previous page URL
     */
    public function previousPageUrl()
    {
        if ($this->currentPage > 1) {
            return $this->url($this->currentPage - 1);
        }
        return null;
    }

    /**
     * Get next page URL
     */
    public function nextPageUrl()
    {
        if ($this->currentPage < $this->lastPage) {
            return $this->url($this->currentPage + 1);
        }
        return null;
    }

    /**
     * Get URL for a given page
     */
    public function url($page)
    {
        $query = $this->query;
        $query['page'] = $page;
        
        return $this->path . '?' . http_build_query($query);
    }

    /**
     * Get current path
     */
    protected function getCurrentPath()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return $path ?: '/';
    }

    /**
     * Get current query parameters
     */
    protected function getCurrentQuery()
    {
        $query = $_GET;
        unset($query['page']); // Remove page parameter
        return $query;
    }

    /**
     * Get range of page numbers to show
     */
    public function getUrlRange($start, $end)
    {
        $urls = [];
        for ($i = $start; $i <= $end; $i++) {
            $urls[$i] = $this->url($i);
        }
        return $urls;
    }

    /**
     * Generate pagination links HTML
     */
    public function links($view = null)
    {
        if (!$this->hasPages()) {
            return '';
        }

        $html = '<nav aria-label="Pagination Navigation">';
        $html .= '<ul class="flex items-center space-x-1">';

        // Previous button
        if ($this->onFirstPage()) {
            $html .= '<li><span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Previous</span></li>';
        } else {
            $html .= '<li><a href="' . $this->previousPageUrl() . '" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">Previous</a></li>';
        }

        // Page numbers
        $start = max(1, $this->currentPage - 2);
        $end = min($this->lastPage, $this->currentPage + 2);

        // Show first page if not in range
        if ($start > 1) {
            $html .= '<li><a href="' . $this->url(1) . '" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">1</a></li>';
            if ($start > 2) {
                $html .= '<li><span class="px-3 py-2 text-gray-400">...</span></li>';
            }
        }

        // Page range
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $this->currentPage) {
                $html .= '<li><span class="px-3 py-2 text-white bg-soft-pink-500 border border-soft-pink-500 rounded-lg">' . $i . '</span></li>';
            } else {
                $html .= '<li><a href="' . $this->url($i) . '" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">' . $i . '</a></li>';
            }
        }

        // Show last page if not in range
        if ($end < $this->lastPage) {
            if ($end < $this->lastPage - 1) {
                $html .= '<li><span class="px-3 py-2 text-gray-400">...</span></li>';
            }
            $html .= '<li><a href="' . $this->url($this->lastPage) . '" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">' . $this->lastPage . '</a></li>';
        }

        // Next button
        if ($this->onLastPage()) {
            $html .= '<li><span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next</span></li>';
        } else {
            $html .= '<li><a href="' . $this->nextPageUrl() . '" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">Next</a></li>';
        }

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }

    /**
     * Get pagination info text
     */
    public function info()
    {
        $from = ($this->currentPage - 1) * $this->perPage + 1;
        $to = min($this->currentPage * $this->perPage, $this->total);
        
        return "Menampilkan {$from} sampai {$to} dari {$this->total} hasil";
    }

    /**
     * Convert to array for JSON response
     */
    public function toArray()
    {
        return [
            'data' => $this->items,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'per_page' => $this->perPage,
            'total' => $this->total,
            'from' => ($this->currentPage - 1) * $this->perPage + 1,
            'to' => min($this->currentPage * $this->perPage, $this->total),
            'prev_page_url' => $this->previousPageUrl(),
            'next_page_url' => $this->nextPageUrl(),
        ];
    }

    /**
     * Make paginator iterable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Count items
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Check if empty
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Check if not empty
     */
    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }
}

?> 