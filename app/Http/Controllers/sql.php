<?php

/**
 * @api {sql} /lbs/orders 工单表
 * @apiDescription 定位工单表字段
 * @apiGroup Table-SQL
 * @apiParam {bigint}  id  主键ID
 * @apiParam {smallint}  state  工单状态(0:未接单，1:已接), 默认值：`0`
 * @apiParam {bigint}  order_id  工单关联id, 默认值：`NOT NULL`
 * @apiParam {varchar(128)}  full_address  联系人地址, 默认值：`NOT NULL`
 * @apiParam {varchar(16)}  user_name  联系人姓名, 默认值：`NOT NULL`
 * @apiParam {char(12)}  user_mobile  联系人电话, 默认值：`NOT NULL`
 * @apiParam {varchar(64)}  merchant_name  厂商名称, 默认值：`NOT NULL`
 * @apiParam {char(12)}  merchant_telphone  厂商联系方式, 默认值：`NOT NULL`
 * @apiParam {text}  description  工单描述, 默认值：`NOT NULL`
 * @apiParam {bigint}  category_id  分类id, 默认值：`0`
 * @apiParam {varchar}  category_name  分类名称, 默认值：`""`
 * @apiParam {geometry(Point)} geom  位置坐标(注：字段类型为`geometry(Point,4326)`), 默认值：`NOT NULL`
 * @apiParam {timestamp} created_at  创建时间, 默认值：`NULL`
 * @apiParam {timestamp} updated_at  修改时间, 默认值：`NULL`
 * @apiVersion 0.1.0
 * @apiSuccessExample {json} SQL语句:
 * {
 * "CREATE TABLE orders (
 * id bigint NOT NULL,
 * order_id bigint NOT NULL,
 * description text,
 * state smallint DEFAULT '0'::smallint NOT NULL,
 * merchant_name character varying(64) DEFAULT ''::character varying NOT NULL,
 * merchant_telphone character varying(12) DEFAULT ''::character varying NOT NULL,
 * category_id bigint DEFAULT '0'::bigint NOT NULL,
 * category_name character varying(200) DEFAULT ''::character varying NOT NULL,
 * user_name character varying(255) DEFAULT ''::character varying NOT NULL,
 * user_mobile character varying(12) DEFAULT ''::character varying NOT NULL,
 * full_address character varying(255) DEFAULT ''::character varying NOT NULL,
 * geom geometry(Point,4326) NOT NULL,
 * created_at timestamp(0) without time zone,
 * updated_at timestamp(0) without time zone
 * );
 *
 * ALTER TABLE orders OWNER TO postgres;
 *
 *CREATE SEQUENCE orders_id_seq
 * START WITH 1
 * INCREMENT BY 1
 * NO MINVALUE
 * NO MAXVALUE
 * CACHE 1;
 *
 * ALTER TABLE orders_id_seq OWNER TO postgres;
 *
 * ALTER SEQUENCE orders_id_seq OWNED BY orders.id;
 * "
 * }
 */


/**
 * @api {sql} /lbs/workers 师傅表
 * @apiDescription 定位师傅表字段
 * @apiGroup Table-SQL
 * @apiParam {bigint}  id  主键ID
 * @apiParam {varchar(100)}  name  姓名：(`NOT NULL`)
 * @apiParam {char(12)}  mobile  电话：(`NOT NULL`)
 * @apiParam {text}  full_address  地址：(`NOT NULL`)
 * @apiParam {bigint}  uid  关联ID：(`NOT NULL`)
 * @apiParam {geometry(Point)}  geom  地址(注：字段类型为`geometry(Point,4326)`)：(`NOT NULL`)
 * @apiParam {smallint}  state  工单状态(0:正常`默认`，1:锁定)
 * @apiParam {timestamp} created_at  创建时间：(`NULL`)
 * @apiParam {timestamp} updated_at  修改时间：(`NULL`)
 * @apiVersion 0.1.0
 * @apiSuccessExample {json} SQL语句:
 * {
 * CREATE TABLE workers (
 * id bigint NOT NULL,
 * name character varying(100) NOT NULL,
 * mobile character varying(12) NOT NULL,
 * state smallint DEFAULT '0'::smallint NOT NULL,
 * full_address text NOT NULL,
 * uid bigint DEFAULT '0'::bigint NOT NULL,
 * geom geometry(Point,4326) NOT NULL,
 * created_at timestamp(0) without time zone,
 * updated_at timestamp(0) without time zone
 * );
 * "
 * }
 */