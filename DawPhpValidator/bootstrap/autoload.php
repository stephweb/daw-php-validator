<?php

/**
 * Si l'utilisateur n'a pas téléchargé ce package avec Composer, il devra "require" ce fichier
 */

require_once dirname(dirname(__FILE__)).'/Exception/ExceptionHandler.php';

require_once dirname(dirname(__FILE__)).'/Contracts/ValidatorInterface.php';

require_once dirname(dirname(__FILE__)).'/Config/SingletonConfig.php';

require_once dirname(dirname(__FILE__)).'/Config/Config.php';

require_once dirname(dirname(__FILE__)).'/Config/Lang.php';

require_once dirname(dirname(__FILE__)).'/Validator.php';

require_once dirname(dirname(__FILE__)).'/HtmlRenderer.php';

require_once dirname(dirname(__FILE__)).'/JsonRenderer.php';