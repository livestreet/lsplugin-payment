<?php

class PluginPayment_Update_CreateTable extends ModulePluginManager_EntityUpdate
{
    /**
     * Выполняется при обновлении версии
     */
    public function up()
    {
        if (!$this->isTableExists('prefix_payment')) {
            /**
             * При активации выполняем SQL дамп
             */
            $this->exportSQL(Plugin::GetPath(__CLASS__) . '/update/2.0.0/dump.sql');
        }
    }

    /**
     * Выполняется при откате версии
     */
    public function down()
    {

    }
}