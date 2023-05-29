<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master_item_type}}`.
 */
class m230515_095515_create_master_item_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%master_item_type}}', [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer(50),
            'type_name' => $this->string(50),
            'created_at' => $this->dateTime(),
            
        ]);

        $this->addForeignKey(
            'fk-master_item_type-activity_id',
            '{{%master_item_type}}',
            'activity_id',
            '{{%master_activity}}',
            'id',
            'CASCADE'
        );

        $activity = $this->db->createCommand('SELECT * FROM {{%master_activity}} WHERE id=:id')
        ->bindValue(':id', '1')
        ->queryOne();

        $this->batchInsert(
            '{{%master_item_type}}',
            ['activity_id', 'type_name', 'created_at'],
            [
                [$activity['id'],'General', date("Y-m-d H:i:s")],
            ]
        );

        $activity = $this->db->createCommand('SELECT * FROM {{%master_activity}} WHERE id=:id')
        ->bindValue(':id', '2')
        ->queryOne();

        $this->batchInsert(
            '{{%master_item_type}}',
            ['activity_id', 'type_name', 'created_at'],
            [
                [$activity['id'],'Engineer',date("Y-m-d H:i:s")],
                [$activity['id'],'Technical Leader',date("Y-m-d H:i:s")],
                [$activity['id'],'Technical',date("Y-m-d H:i:s")],
                [$activity['id'],'Technician HTW (Including HTW Tools)',date("Y-m-d H:i:s")],
                [$activity['id'],'Valve Technical Expert/Inspector ',date("Y-m-d H:i:s")],
            ]
        );


        $activity = $this->db->createCommand('SELECT * FROM {{%master_activity}} WHERE id=:id')
        ->bindValue(':id', '3')
        ->queryOne();

        $this->batchInsert(
            '{{%master_item_type}}',
            ['activity_id', 'type_name', 'created_at'],
            [
                [$activity['id'],'Ball Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Butterfly Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Globe Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Gate and Plug Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Choke Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Check Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Control Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Actuator ',date("Y-m-d H:i:s")],
                [$activity['id'],'STARPAC Control Valve & Actuator',date("Y-m-d H:i:s")],
                [$activity['id'],'4 way Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Twin Seal',date("Y-m-d H:i:s")],
                [$activity['id'],'Rising Stem Ball Valves',date("Y-m-d H:i:s")],
                [$activity['id'],'Breather Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Emergency Vent  / Vent Stack',date("Y-m-d H:i:s")],
                [$activity['id'],'Pressure Safety Valve (PSV)',date("Y-m-d H:i:s")],
            ]
        );


        $activity = $this->db->createCommand('SELECT * FROM {{%master_activity}} WHERE id=:id')
        ->bindValue(':id', '4')
        ->queryOne();

        $this->batchInsert(
            '{{%master_item_type}}',
            ['activity_id', 'type_name', 'created_at'],
            [

                [$activity['id'],'Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'SDV/BDV',date("Y-m-d H:i:s")],
                [$activity['id'],'Actuator',date("Y-m-d H:i:s")],
                [$activity['id'],'Control Valve',date("Y-m-d H:i:s")],
                [$activity['id'],'Pressure Safety Valve (PSV)',date("Y-m-d H:i:s")],
                [$activity['id'],'Emergency Vent Tank / Vent Stack',date("Y-m-d H:i:s")],
                [$activity['id'],'Breather Valve',date("Y-m-d H:i:s")],
            ]
        );


        
        $activity = $this->db->createCommand('SELECT * FROM {{%master_activity}} WHERE id=:id')
        ->bindValue(':id', '5')
        ->queryOne();

        $this->batchInsert(
            '{{%master_item_type}}',
            ['activity_id', 'type_name', 'created_at'],
            [
                [$activity['id'],'Trim Kits Part',date("Y-m-d H:i:s")],
                [$activity['id'],'Handwheel (Fabricate)',date("Y-m-d H:i:s")],
            ]
        );




    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%master_item_type}}');
    }
}
