<?php

namespace webu\system\Core\Contents\Modules;


use webu\system\Core\Base\Custom\FileEditor;

class ModuleCacher {

    const MODULE_CACHE_FILE = ROOT . CACHE_DIR . "\\private\\generated\\modules\\module_cache.json";

    /**
     * @param ModuleCollection $moduleCollection
     */
    public static function createModuleCache(ModuleCollection $moduleCollection) {
        $collectionArray = array();

        /** @var Module $module */
        foreach($moduleCollection->getModuleList() as $module) {

            $moduleControllerArray = array();
            /** @var ModuleController $moduleController */
            foreach($module->getModuleControllers() as $moduleController) {
                $moduleControllerArray[] = [
                    "name" => $moduleController->getName(),
                    "class" => $moduleController->getClass(),
                    "actions" => $moduleController->getActionsAsArray()
                ];
            }

            $moduleArray = [
                "informations" => $module->getInformation(),
                "moduleName" => $module->getName(),
                "moduleControllers" => $moduleControllerArray,
                "basePath" => $module->getBasePath(),
                "resourcePath" => $module->getRelativeResourcePath(),
                "resourceWeight" => $module->getResourceWeight(),
                "resourceNamespace" => $module->getResourceNamespace(),
                "resourceNamespaceRaw" => $module->getResourceNamespaceRaw(),
                "usingNamespaces" => $module->getUsingNamespaces(),
                "id" => $module->getId(),
                "active" => $module->isActive()
            ];


            $collectionArray[] = $moduleArray;

            FileEditor::createFile(self::MODULE_CACHE_FILE, json_encode($collectionArray));
        }



    }

    /**
     * @return bool|ModuleCollection
     */
    public static function readModuleCache() {
        if(!file_exists(self::MODULE_CACHE_FILE)) return false;

        $moduleCollectionArray = json_decode(FileEditor::getFileContent(self::MODULE_CACHE_FILE));

        //Convert Array to Object
        $moduleCollection = new ModuleCollection();


        foreach($moduleCollectionArray as $moduleArray) {
            $module = new Module(
                $moduleArray->moduleName
            );
            $module->setBasePath($moduleArray->basePath);
            $module->setResourcePath($moduleArray->resourcePath);
            $module->setResourceWeight($moduleArray->resourceWeight);
            $module->setResourceNamespace($moduleArray->resourceNamespace);
            $module->setResourceNamespaceRaw($moduleArray->resourceNamespaceRaw);
            $module->setUsingNamespaces($moduleArray->usingNamespaces);
            $module->setId($moduleArray->id);
            $module->setActive((bool)$moduleArray->active);

            foreach($moduleArray->moduleControllers as $id => $moduleControllerArray) {

                $moduleControllerActions = [];
                foreach((array)$moduleControllerArray->actions as $action) {
                    $moduleControllerActions[] = new ModuleAction(
                        $action->id,
                        $action->c_url,
                        $action->action
                    );
                }

                $moduleController = new ModuleController(
                    $moduleControllerArray->class,
                    $moduleControllerArray->name,
                    $moduleControllerActions);
                $module->addModuleController($moduleController);
            }


            foreach($moduleArray->informations as $key => $information) {
                $module->setInformation($key, $information);
            }

            $moduleCollection->addModule($module);
        }


        return $moduleCollection;
    }

}