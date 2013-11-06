<?php



define('PLATEFORME_INDEX', 1);
define('PROJECT_INDEX', 2);
define('GLOBAL_PROJECT', 'global');
class Auth extends \Slim\Middleware
{

    public function __construct()
    {

    }

    public function call()
    {
        $url = $this->app->request()->getResourceUri();
        $folders = explode('/', substr($url, 1));
        if (sizeof((array)$folders) >= 3) {
            //minimum folders = apps / ios / project
            if ($folders[0] == 'apps') {

                if (isset($_SERVER['PHP_AUTH_USER']) && isset($folders[PROJECT_INDEX])) {
                    $currentUser = $_SERVER['PHP_AUTH_USER'];

                    $rules = array();
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
                        $rules[$currentProject][] = $user;
                    }

                    $project = $folders[PROJECT_INDEX];

                    if (empty($rules)) {
                        //Allow from all
                        $hasCredentials = true;
                    } else {
                        //Deny from all
                        $hasCredentials = false;

                        // currentUser is a project user
                        if (isset($rules[$project]) && in_array($currentUser, $rules[$project])) {
                            $hasCredentials = true;
                        }

                        // currentUser is a power user
                        if (isset($rules[GLOBAL_PROJECT]) && in_array($currentUser, $rules[GLOBAL_PROJECT])) {
                            $hasCredentials = true;
                        }

                    }


                    if (!$hasCredentials) {
                        header('WWW-Authenticate: Basic realm="Secured area"');
                        header('HTTP/1.0 401 Unauthorized');
                        $this->app->render('pages/unauthorized.twig', array(
                                'parent_url' => toUrl(join('/', array_slice($folders, 0, sizeof($folders) - 1))),
                                'parent' => $folders[sizeof($folders) - 2]
                            )
                        );
                        return;
                    }
                }
            }
        }


        $this->next->call();

    }
}