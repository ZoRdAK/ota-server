<?php



define('PROJECT_INDEX', 1);
define('GLOBAL_PROJECT', 'global');
class Auth extends \Slim\Middleware
{

    public function __construct()
    {

    }

    public function call()
    {
        $url = $this->app->request()->getResourceUri();
        if (substr($url, 0, 5) == '/apps') {
            $folders = explode('/',substr($url,6));

            if (isset($_SERVER['PHP_AUTH_USER']) && isset($folders[PROJECT_INDEX])) {
                $currentUser = $_SERVER['PHP_AUTH_USER'];

                $projects = array();
                $currentProject = GLOBAL_PROJECT;
                foreach (explode("\n", file_get_contents(DIR . '/.htpasswd')) as $k => $line) {
                    if (trim($line) == '') {
                        continue;
                    }

                    // Group found
                    if (substr($line, 0, 1) == '#') {
                        $currentProject = trim(str_replace('#', '', $line));
                        continue;
                    }

                    // User found
                    $user = substr($line, 0, strpos($line, ':'));
                    $projects[$currentProject][] = $user;
                }

                $project = $folders[PROJECT_INDEX];
                if ( !in_array($currentUser, $projects[GLOBAL_PROJECT]) && ( !isset($projects[$project]) || !in_array($currentUser, $projects[$project]))) {
                    header('WWW-Authenticate: Basic realm="Projet protege"');
                    header('HTTP/1.0 401 Unauthorized');
                    $this->app->render('pages/unauthorized.twig');
                    return;
                }
            }
        }


        $this->next->call();

    }
}