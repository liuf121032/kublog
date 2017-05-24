<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/5/23
 * Time: 10:56
 *
 * 1.Mysql 索引类型： 全文索引 fulltext, 主键索引 primary key ,唯一索引 Unique ,普通索引 index
 *
 * 唯一索引的意思，在索引列的字段值必须是唯一的，但是可以为null,null不适合索引优化。所以，字段最好定义为is not null.
 *
 * 主键索引，一般设置为ID字段，自增的，也必须是唯一的，但是不能为空。
 *
 * 2.添加索引
 * 主键索引：  Alter table `table_name` add PRIMARY KEY(`colunm`);
 *
 * 唯一索引：  Alter table `table_name`add unique(`column`);   比如：   alter table it_asset add unique it_create_time;
 *
 * 普通索引： Alter table `table_name` add index_name(`column`);         alter table it_asset add index_name(assetclass);
 *
 * 全文索引：Alter table `table_name` add FULLTEXT('column');      全文索引的字段类型必须为：char varcha text ,支持中文的全文索引分词 就用第三方的插件 sphinx
 *
 * 多列组合索引： Alter table `table_name` add index index_name(`column`,`column`,`column`);   index_name　是索引名称，给索引取名称
 *
 * 3.删除索引  Alter　table `table_name` drop index index_name , alter table `table_name` drop primary key,
 *       或者  Drop index index_name on `table_name`
 *
 *
 *
 *
 *
 */