<?php

/**
 * TechDivision\Import\Dbal\Collection\Repositories\Finders\CoreConfigDataFinder
 *
 * PHP version >= 7
 *
 * @author    MET <met@techdivision.com>
 * @copyright 2022 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
declare(strict_types=1);

namespace TechDivision\Import\Dbal\Collection\Repositories\Finders;

use TechDivision\Import\Dbal\Configuration\ConfigurationInterface;
use TechDivision\Import\Dbal\Repositories\Finders\FinderInterface;
use TechDivision\Import\SystemLoggerTrait;
use Doctrine\Common\Collections\Collection;

/**
 * CoreConfigDataFinder finder implementation.
 *
 * @author    MET <met@techdivision.com>
 * @copyright 2022 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class CoreConfigDataFinder implements FinderInterface
{

    /**
     * The trait that provides basic filesystem handling functionality.
     *
     * @var \TechDivision\Import\SystemLoggerTrait
     */
    use SystemLoggerTrait;

    /**
     * The variable name for the Api url.
     *
     * @var string
     */
    public const REST_API_URL = 'rest/all/V1/pacemakerImport/config/getAll';

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * The unique key of the prepared statement that has to be executed.
     *
     * @var string
     */
    protected $key;

    /**
     * The entity's primary key name.
     *
     * @var string
     */
    protected $primaryKeyName;

    /**
     * The finder's entity name.
     *
     * @var string
     */
    protected $entityName;

    /**
     * Initialize the repository with the passed connection and utility class name.
     *
     * @param string                 $key            The unique key of the prepared statement that has to be executed.
     * @param string                 $primaryKeyName The entity's primary key
     * @param string                 $entityName     The finder's entity name
     * @param ConfigurationInterface $configuration  The configuration instance
     * @param Collection             $systemLoggers  The systemLogger instance
     */
    public function __construct(
        string $key,
        string $primaryKeyName,
        string $entityName,
        ConfigurationInterface $configuration,
        Collection $systemLoggers
    ) {
        $this->primaryKeyName = $primaryKeyName;
        $this->entityName = $entityName;
        $this->key = $key;
        $this->configuration = $configuration;
        $this->systemLoggers = $systemLoggers;
    }

    /**
     * @param array $params The finder params
     *
     * @return array|mixed
     */
    public function find(array $params = array())
    {
        $apiData = $this->configuration->getApiData();
        if (empty($apiData)) {
            return [];
        }
        if (!isset($apiData['magento-domain']) || empty($apiData['magento-domain'])) {
            return [];
        }
        $path = sprintf("%s/%s", $apiData['magento-domain'], self::REST_API_URL);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($path);
            if ($response->getStatusCode() >= 400) {
                return [];
            }
            $jsonData = json_decode($response->getBody()->getContents(), true);
            if (!$jsonData) {
                return [];
            }
        } catch (\Exception $e) {
            $this->getSystemLogger()->warning(
                sprintf(
                    'Something wrong with Call Magento Api on %s - Error message: %s',
                    $path,
                    $e->getMessage()
                )
            );

            $jsonData = [];
        }
        return $jsonData;
    }

    /**
     * Return's the finder's unique key.
     *
     * @return string The unique key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Return's the entity's primary key name.
     *
     * @return string The entity's primary key name
     */
    public function getPrimaryKeyName()
    {
        return $this->primaryKeyName;
    }

    /**
     * Return's the finder's entity name.
     *
     * @return string The finder's entity name
     */
    public function getEntityName()
    {
        return $this->entityName;
    }
}
