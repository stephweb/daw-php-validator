<?php

/**
 * Si le package n'a pas été téléchargé avec Composer, il faut "require" manuellement ce fichier
 */

require_once dirname(dirname(__FILE__)).'/Exception/ExceptionHandler.php';

require_once dirname(dirname(__FILE__)).'/Contracts/Config/ConfigInterface.php';

require_once dirname(dirname(__FILE__)).'/Contracts/ValidatorInterface.php';

require_once dirname(dirname(__FILE__)).'/Config/SingletonConfig.php';

require_once dirname(dirname(__FILE__)).'/Config/Config.php';

require_once dirname(dirname(__FILE__)).'/Config/Lang.php';

require_once dirname(dirname(__FILE__)).'/Validator.php';

require_once dirname(dirname(__FILE__)).'/HtmlRenderer.php';

require_once dirname(dirname(__FILE__)).'/JsonRenderer.php';
