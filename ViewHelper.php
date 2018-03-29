<?php
class ViewHelper {
    //Displays a given view and sets the $variables array into scope.
    public static function render($file, $variables = array()) {
        extract($variables);
        ob_start();
        include($file);
        $renderedView = ob_get_clean();
        echo $renderedView;
    }
    
    public static function renderJSON($data, $httpResponseCode) {
        header('Content-Type: application/json');
        http_response_code($httpResponseCode);
        return json_encode($data);
    }
    
    // Redirects to the given URL
        // DON'T SEND ANY HTML CONTENT BEFORE CALLING REDIRECT
    public static function redirect($url) {

        header("Location: " . $url);
    }
    
    // Displays a simple 401 message
    public static function error401() {
        header('Unauthorized', true, 401);
        $html401 = sprintf("<title>Error 401: Unauthorized</title>\n" .
            "<main><div class=\"container\"><div class=\"row\"><div class=\"col-lg-10 offset-lg-1\">" .
            "<div class=\"row wow fadeIn\" data-wow-delay=\"0.4s\"><div class=\"col-lg-12\"><div class=\"divider-new\">" .
            "<h2 class=\"h2-responsive\">Error 401</h2>" .
            "</div></div>" .
            "<div class=\"col-lg-12 text-center\">" .
            "<p>You aren’t authenticated, please login and try again.</p>" .
            "</div></div></div></div></div></main>", $_SERVER["REQUEST_URI"]);
        echo $html401;
    }
    
    // Displays a simple 403 message
    public static function error403() {
        header('Forbidden', true, 403);
        $html403 = sprintf("<title>Error 403: Forbidden</title>\n" .
            "<main><div class=\"container\"><div class=\"row\"><div class=\"col-lg-10 offset-lg-1\">" .
            "<div class=\"row wow fadeIn\" data-wow-delay=\"0.4s\"><div class=\"col-lg-12\"><div class=\"divider-new\">" .
            "<h2 class=\"h2-responsive\">Error 403</h2>" .
            "</div></div>" .
            "<div class=\"col-lg-12 text-center\">" .
            "<p>You don’t have permission to access this resource.</br>
                If you think that this is a mistake, please contact the system administrator.</p>" .
            "</div></div></div></div></div></main>", $_SERVER["REQUEST_URI"]);
        echo $html403;
    }
    
    // Displays a simple 404 message
    public static function error404() {
        header('This is not the page you are looking for', true, 404);
        $html404 = sprintf("<title>Error 404: Not Found</title>\n" .
            "<main><div class=\"container\"><div class=\"row\"><div class=\"col-lg-10 offset-lg-1\">" .
            "<div class=\"row wow fadeIn\" data-wow-delay=\"0.4s\"><div class=\"col-lg-12\"><div class=\"divider-new\">" .
            "<h2 class=\"h2-responsive\">Error 404</h2>" .
            "</div></div>" .
            "<div class=\"col-lg-12 text-center\">" .
            "<p>The page <i>%s</i> does not exist.</p>" .
            "</div></div></div></div></div></main>", $_SERVER["REQUEST_URI"]);
        echo $html404;
    }
    
    // Displays a simple 405 message
    public static function error405() {
        header('Method Not Allowed', true, 404);
        $html405 = sprintf("<title>Error 405: Method Not Allowed</title>\n" .
            "<main><div class=\"container\"><div class=\"row\"><div class=\"col-lg-10 offset-lg-1\">" .
            "<div class=\"row wow fadeIn\" data-wow-delay=\"0.4s\"><div class=\"col-lg-12\"><div class=\"divider-new\">" .
            "<h2 class=\"h2-responsive\">Error 405</h2>" .
            "</div></div>" .
            "<div class=\"col-lg-12 text-center\">" .
            "<p>The method received in the request-line is not supported by the target resource.</p>" .
            "</div></div></div></div></div></main>", $_SERVER["REQUEST_URI"]);
        echo $html405;
    }
    
    // Returns true if the request is AJAX
    public static function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}?>
