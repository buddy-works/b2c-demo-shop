<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Pyz\Yves\Collector\Communication;

use Generated\Yves\Ide\FactoryAutoCompletion\CollectorCommunication;
use Pyz\Yves\Collector\Communication\Creator\ResourceCreatorInterface;
use Pyz\Yves\Collector\Communication\Mapper\UrlMapper;
use SprykerFeature\Client\Catalog\Service\Model\FacetConfig;
use SprykerFeature\Client\Collector\Service\Matcher\UrlMatcher;
use SprykerEngine\Yves\Kernel\Communication\AbstractCommunicationDependencyContainer;
use Silex\Application;

class CollectorDependencyContainer extends AbstractCommunicationDependencyContainer
{

    /**
     * @return ResourceCreatorInterface[]
     */
    public function createResourceCreators()
    {
        return [
            $this->getLocator()->product()->pluginProductResourceCreator()->createProductResourceCreator(),
            $this->getLocator()->category()->pluginCategoryResourceCreator()->createCategoryResourceCreator(),
            $this->getLocator()->redirect()->pluginRedirectResourceCreator()->createRedirectResourceCreator(),
            $this->getLocator()->cms()->pluginPageResourceCreator()->createPageResourceCreator(),
        ];
    }

    /**
     * @return UrlMapper
     */
    public function createUrlMapper()
    {
        return new UrlMapper(
            $this->createFacetConfig()
        );
    }

    /**
     * @return UrlMatcher
     */
    public function createUrlMatcher()
    {
        $urlMatcher = $this->getLocator()->collector()->client();

        return $urlMatcher;
    }

    /**
     * @return FacetConfig
     */
    protected function createFacetConfig()
    {
        return $this->getLocator()->catalog()->client()->createFacetConfig();
    }

    /**
     * @return Application
     */
    public function createApplication()
    {
        return $this->getLocator()->application()->pluginPimple()->getApplication();
    }

}
