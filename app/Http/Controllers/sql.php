<?php

/**
 * @api {sql} /lbs/orders 工单表
 * @apiDescription LBS系统工单表结构
 * @apiGroup Z-Table-SQL
 * @apiParam {bigint}  id  主键ID
 * @apiParam {tinyInt}  state  工单状态, 默认值：`0`
 * @apiParam {bigint}  order_no  工单号,
 * @apiParam {varchar}  order_desc  工单描述
 * @apiParam {tinyInt}  order_type  0保内/1保外, 默认值：`0`
 * @apiParam {tinyInt}  biz_type  0安装/1维修, 默认值：`0`
 * @apiParam {BigInt}  merchant_id  商家id
 * @apiParam {varchar(64)}  merchant_name  厂商名称
 * @apiParam {char(12)}  merchant_tel  厂商联系方式
 * @apiParam {bigint}  user_id  联系人姓名, 默认值
 * @apiParam {varchar(16)}  user_name  联系人姓名
 * @apiParam {char(12)}  user_mobile  联系人电话
 * @apiParam {decimal}  user_lat  纬度
 * @apiParam {decimal}  user_lng  经度
 * @apiParam {varchar(128)}  full_address  联系人地址
 * @apiParam {varchar}  big_cat  大类,默认值:`""`
 * @apiParam {varchar}  middle_cat  中类,默认值:`""`
 * @apiParam {varchar}  small_cat  小类,默认值:`""`
 * @apiParam {geometry(Point)} geom  位置坐标(注：字段类型为`geometry(Point,4326)`), 默认值：`NOT NULL`
 * @apiParam {timestamp} published_at  发布时间, 默认值：`NULL`
 * @apiParam {timestamp} created_at  创建时间, 默认值：`NULL`
 * @apiParam {timestamp} updated_at  修改时间, 默认值：`NULL`
 * @apiVersion 0.1.0
 * @apiSuccessExample {sql} 创建表SQL语句:
 *
 * CREATE TABLE orders (
 * id bigint NOT NULL,
 * order_no character varying(255) NOT NULL,
 * order_desc character varying(255) NOT NULL,
 * state smallint DEFAULT '0'::smallint NOT NULL,
 * order_type smallint DEFAULT '0'::smallint NOT NULL,
 * biz_type smallint DEFAULT '0'::smallint NOT NULL,
 * merchant_id bigint NOT NULL,
 * merchant_name character varying(64) NOT NULL,
 * merchant_tel character varying(12) NOT NULL,
 * user_id bigint NOT NULL,
 * user_name character varying(255) NOT NULL,
 * user_mobile character varying(12) NOT NULL,
 * user_lat numeric(8,2) NOT NULL,
 * user_lng numeric(8,2) NOT NULL,
 * full_address character varying(255) NOT NULL,
 * geom geometry(Point,4326) NOT NULL,
 * published_at timestamp(0) without time zone NOT NULL,
 * big_cat character varying(255) DEFAULT ''::character varying NOT NULL,
 * middle_cat character varying(255) DEFAULT ''::character varying NOT NULL,
 * small_cat character varying(255) DEFAULT ''::character varying NOT NULL,
 * created_at timestamp(0) without time zone,
 * updated_at timestamp(0) without time zone
 * );
 *
 * ALTER TABLE orders OWNER TO postgres;
 *
 * CREATE SEQUENCE orders_id_seq
 * START WITH 1
 * INCREMENT BY 1
 * NO MINVALUE
 * NO MAXVALUE
 * CACHE 1;
 *
 * ALTER TABLE orders_id_seq OWNER TO postgres;
 * ALTER SEQUENCE orders_id_seq OWNED BY orders.id;
 * ALTER TABLE ONLY orders ALTER COLUMN id SET DEFAULT nextval('orders_id_seq'::regclass);
 * ALTER TABLE ONLY orders ADD CONSTRAINT orders_pkey PRIMARY KEY (id);
 * CREATE INDEX orders_order_no_index ON orders USING btree (order_no);
 */


/**
 * @api {sql} /lbs/workers 师傅表
 * @apiDescription LBS系统师傅表结构
 * @apiGroup Z-Table-SQL
 * @apiParam {bigint}  id  主键ID
 * @apiParam {varchar}  name  姓名
 * @apiParam {char(12)}  mobile  电话
 * @apiParam {varchar}  full_address  地址
 * @apiParam {bigint}  uid  关联ID
 * @apiParam {decimal}  worker_lat  纬度
 * @apiParam {decimal}  worker_lng  经度
 * @apiParam {geometry(Point)}  geom  地址(注：字段类型为`geometry(Point,4326)`)：(`NOT NULL`)
 * @apiParam {tinyInt}  state  工单状态(0:正常，1:锁定),默认值：`0`
 * @apiParam {timestamp} created_at  创建时间,默认值：`NULL`
 * @apiParam {timestamp} updated_at  修改时间,默认值：(`NULL`)
 * @apiVersion 0.1.0
 * @apiSuccessExample {sql} 创建SQL语句:
 *
 * CREATE TABLE workers (
 * id bigint NOT NULL,
 * name character varying(100) NOT NULL,
 * mobile character varying(12) NOT NULL,
 * state smallint DEFAULT '0'::smallint NOT NULL,
 * worker_lat numeric(8,2) NOT NULL,
 * worker_lng numeric(8,2) NOT NULL,
 * full_address text NOT NULL,
 * uid bigint DEFAULT '0'::bigint NOT NULL,
 * geom geometry(Point,4326) NOT NULL,
 * created_at timestamp(0) without time zone,
 * updated_at timestamp(0) without time zone
 * );
 * ALTER TABLE workers OWNER TO postgres;
 * CREATE SEQUENCE workers_id_seq
 * START WITH 1
 * INCREMENT BY 1
 * NO MINVALUE
 * NO MAXVALUE
 * CACHE 1;
 *
 * ALTER TABLE workers_id_seq OWNER TO postgres;
 * ALTER SEQUENCE workers_id_seq OWNED BY workers.id;
 * ALTER TABLE ONLY workers ALTER COLUMN id SET DEFAULT nextval('workers_id_seq'::regclass);
 * ALTER TABLE ONLY workers ADD CONSTRAINT workers_pkey PRIMARY KEY (id);
 * CREATE INDEX workers_uid_index ON workers USING btree (uid);
 */