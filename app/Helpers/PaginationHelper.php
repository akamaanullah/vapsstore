<?php
namespace App\Helpers;

class PaginationHelper {
    /**
     * Render pagination links for the UI
     * 
     * @param array $pagination The pagination data from Model::paginate()
     * @param string $baseUrl The base URL for the links
     * @return string HTML for the pagination
     */
    public static function render($pagination, $baseUrl) {
        if ($pagination['last_page'] <= 1) {
            return '';
        }

        $currentPage = $pagination['current_page'];
        $lastPage = $pagination['last_page'];
        
        $html = '<nav class="pagination-container" aria-label="Page navigation">';
        $html .= '<ul class="pagination">';

        // Previous Link
        $prevClass = ($currentPage <= 1) ? 'disabled' : '';
        $prevUrl = ($currentPage <= 1) ? '#' : self::appendQueryParam($baseUrl, 'page', $currentPage - 1);
        $html .= '<li class="page-item ' . $prevClass . '">';
        $html .= '<a class="page-link" href="' . $prevUrl . '" aria-label="Previous">&laquo;</a>';
        $html .= '</li>';

        // Page Numbers
        for ($i = 1; $i <= $lastPage; $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : '';
            $url = self::appendQueryParam($baseUrl, 'page', $i);
            $html .= '<li class="page-item ' . $activeClass . '">';
            $html .= '<a class="page-link" href="' . $url . '">' . $i . '</a>';
            $html .= '</li>';
        }

        // Next Link
        $nextClass = ($currentPage >= $lastPage) ? 'disabled' : '';
        $nextUrl = ($currentPage >= $lastPage) ? '#' : self::appendQueryParam($baseUrl, 'page', $currentPage + 1);
        $html .= '<li class="page-item ' . $nextClass . '">';
        $html .= '<a class="page-link" href="' . $nextUrl . '" aria-label="Next">&raquo;</a>';
        $html .= '</li>';

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }

    private static function appendQueryParam($url, $key, $value) {
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query) {
            parse_str($query, $params);
            $params[$key] = $value;
            $newQuery = http_build_query($params);
            return explode('?', $url)[0] . '?' . $newQuery;
        } else {
            return $url . '?' . $key . '=' . $value;
        }
    }
}
