<?php

namespace Jsor\Doctrine\PostGIS\Event;

use Doctrine\ORM\Tools\ToolEvents;
use Doctrine\ORM\Tools\Event\GenerateSchemaTableEventArgs;

class ORMSchemaEventSubscriber extends DBALSchemaEventSubscriber
{
    public function getSubscribedEvents()
    {
        return array_merge(
            parent::getSubscribedEvents(),
            array(
                ToolEvents::postGenerateSchemaTable
            )
        );
    }

    public function postGenerateSchemaTable(GenerateSchemaTableEventArgs $args)
    {
        $table = $args->getClassTable();

        foreach ($table->getColumns() as $column) {
            if (!$this->isSpatialColumnType($column)) {
                continue;
            }

            $normalized = $column->getType()->getNormalizedSpatialOptions(
                $column->getCustomSchemaOptions()
            );

            foreach ($normalized as $name => $value) {
                $column->setCustomSchemaOption($name, $value);
            }
        }

        // Add SPATIAL flags to indexes
        if ($table->hasOption('spatial_indexes')) {
            foreach ((array) $table->getOption('spatial_indexes') as $indexName) {
                if (!$table->hasIndex($indexName)) {
                    continue;
                }

                $table->getIndex($indexName)->addFlag('SPATIAL');
            }
        }
    }
}
