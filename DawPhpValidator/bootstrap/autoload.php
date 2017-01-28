<?php

/**
 * Si le package n'a pas été téléchargé avec Composer, il faut "require" manuellement ce fichier
 */

require_once dirname(dirname(__FILE__)).'/Exception/ExceptionHandler.php';

require_once dirname(dirname(__FILE__)).'/Support/Facades/Facade.php';

require_once dirname(dirname(__FILE__)).'/Support/Facades/Request.php';

require_once dirname(dirname(__FILE__)).'/Support/Request/Bags/ParameterBag.php';

require_once dirname(dirname(__FILE__)).'/Support/Request/Request.php';

require_once dirname(dirname(__FILE__)).'/Support/String/Json.php';

require_once dirname(dirname(__FILE__)).'/Support/String/Str.php';

require_once dirname(dirname(__FILE__)).'/Contracts/Config/ConfigInterface.php';

require_once dirname(dirname(__FILE__)).'/Contracts/ValidatorInterface.php';

require_once dirname(dirname(__FILE__)).'/Config/SingletonConfig.php';

require_once dirname(dirname(__FILE__)).'/Config/Config.php';

require_once dirname(dirname(__FILE__)).'/Config/Lang.php';

require_once dirname(dirname(__FILE__)).'/HtmlRenderer.php';

require_once dirname(dirname(__FILE__)).'/JsonRenderer.php';

require_once dirname(dirname(__FILE__)).'/Validator.php';
