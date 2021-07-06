<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGetPropertiesByGenericCitySearchProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE PROCEDURE getPropertiesByGenericCitySearch(
        IN last_id BIGINT,
        IN city_id BIGINT,
        IN data_limit int(10),
        IN activated_at_value VARCHAR(20),
        IN price_value VARCHAR(20),
        IN sort_area_value VARCHAR(20),
        IN term (TEXT)
         BEGIN
    SELECT
        `properties`.`id`,
        `properties`.`reference`,
        `properties`.`user_id`,
        `properties`.`purpose`,
        `properties`.`sub_purpose`,
        `properties`.`sub_type`,
        `properties`.`type`,
        `properties`.`title`,
        `properties`.`description`,
        `properties`.`price`,
        `properties`.`land_area`,
        `properties`.`area_unit`,
        `properties`.`bedrooms`,
        `properties`.`bathrooms`,
        `properties`.`features`,
        `properties`.`silver_listing`,
        `properties`.`golden_listing`,
        `properties`.`contact_person`,
        `properties`.`phone`,
        `properties`.`cell`,
        `properties`.`fax`,
        `properties`.`email`,
        `properties`.`favorites`,
        `properties`.`views`,
        `properties`.`status`,
        `f`.`user_id` AS `user_favorite`,
        `properties`.`created_at`,
        `properties`.`activated_at`,
        `properties`.`updated_at`,
        `locations`.`name` AS `location`,
        `cities`.`name` AS `city`,
        `p`.`name` AS `image`,
        `properties`.`area_in_sqft`,
        `area_in_sqyd`,
        `area_in_marla`,
        `area_in_new_marla`,
        `area_in_kanal`,
        `area_in_new_kanal`,
        `area_in_sqm`,
        `agencies`.`title` AS `agency`,
        `agencies`.`featured_listing`,
        `agencies`.`logo` AS `logo`,
        `agencies`.`key_listing`,
        `agencies`.`status` AS `agency_status`,
        `agencies`.`phone` AS `agency_phone`,
        `agencies`.`cell` AS `agency_cell`,
        `agencies`.`ceo_name` AS `agent`,
        `agencies`.`created_at` AS `agency_created_at`,
        `agencies`.`description` AS `agency_description`,
        `c`.`property_count` AS `agency_property_count`,
        `users`.`community_nick` AS `user_nick_name`,
        `users`.`name` AS `user_name`
    FROM
        `properties`
    LEFT JOIN `images` AS `p`
    ON
        `p`.`property_id` = `properties`.`id` AND `p`.`name` =(
        SELECT NAME
    FROM
        images
    WHERE
        images.property_id = properties.id AND images.deleted_at IS NULL
    ORDER BY
        images.order
    LIMIT 1
    )
INNER JOIN `locations` ON `properties`.`location_id` = `locations`.`id`
INNER JOIN `cities` ON `properties`.`city_id` = `cities`.`id`
LEFT JOIN `agencies` ON `properties`.`agency_id` = `agencies`.`id`
LEFT JOIN `favorites` AS `f`
ON
    `properties`.`id` = `f`.`property_id` AND `f`.`user_id` = 0
INNER JOIN `users` ON `properties`.`user_id` = `users`.`id`
LEFT JOIN `property_count_by_agencies` AS `c`
ON
    `properties`.`agency_id` = `c`.`agency_id` AND `c`.`property_status` = "active"
WHERE
    `properties`.`status` = "active" AND `properties`.`deleted_at` IS NULL AND `properties`.`city_id` = city_id
    OR INSTR(term,`properties`.`type`) OR  INSTR(term,`properties`.`sub_type`)
ORDER BY
`properties`.`golden_listing` DESC,
`properties`.`silver_listing` DESC,

CASE WHEN
    activated_at_value = "ASC" THEN `properties`.`activated_at`
END ASC,
CASE WHEN activated_at_value = "DESC" THEN `properties`.`activated_at`
END
DESC
    ,
    CASE WHEN price_value = "ASC" THEN `properties`.`price`
END ASC,
CASE WHEN price_value = "DESC" THEN `properties`.`price`
END
DESC
    ,
    CASE WHEN sort_area_value = "ASC" THEN `properties`.`area_in_sqft`
END ASC,
CASE WHEN sort_area_value = "DESC" THEN `properties`.`area_in_sqft`
END
DESC
Limit last_id, data_limit;
END;
');
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('getPropertiesByGenericCitySearch');
    }
}
