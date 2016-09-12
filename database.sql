CREATE SEQUENCE user_seq;

CREATE TABLE "user" (
	id INT NOT NULL DEFAULT NEXTVAL ('user_seq'),
	username VARCHAR(50) NOT NULL,
	password VARCHAR(255) NOT NULL,
	auth_key VARCHAR(32) NOT NULL,
	PRIMARY KEY (id)
);

ALTER SEQUENCE user_seq RESTART WITH 1;


CREATE TABLE "order" (
	id VARCHAR(20) NOT NULL,
	user_id INT NOT NULL,
	created_at INT NULL DEFAULT NULL,
	PRIMARY KEY (id),
	CONSTRAINT fk_order_1 FOREIGN KEY (user_id) REFERENCES "user" (id) ON UPDATE CASCADE
);

CREATE INDEX idx_user_id ON "order" (user_id);


CREATE SEQUENCE product_seq;

CREATE TABLE "product" (
	id INT NOT NULL DEFAULT NEXTVAL ('product_seq'),
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

ALTER SEQUENCE product_seq RESTART WITH 1;


CREATE SEQUENCE type_seq;

CREATE TABLE "type" (
	id INT NOT NULL DEFAULT NEXTVAL ('type_seq'),
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

ALTER SEQUENCE type_seq RESTART WITH 1;


CREATE TABLE "product_type" (
	product_id INT NOT NULL,
	type_id INT NOT NULL,
	PRIMARY KEY (product_id, type_id),
	CONSTRAINT fk_product_type_1 FOREIGN KEY (product_id) REFERENCES "product" (id) ON DELETE CASCADE,
	CONSTRAINT fk_product_type_2 FOREIGN KEY (type_id) REFERENCES "type" (id) ON DELETE CASCADE
);


CREATE SEQUENCE order_item_seq;

CREATE TABLE "order_item" (
	id INT NOT NULL DEFAULT NEXTVAL ('order_item_seq'),
	order_id VARCHAR(20) NOT NULL,
	product_id INT NOT NULL,
	type_id INT NULL DEFAULT NULL,
	quantity INT NOT NULL DEFAULT '1',
	PRIMARY KEY (id),
	CONSTRAINT fk_order_item_1 FOREIGN KEY (order_id) REFERENCES "order" (id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_order_item_2 FOREIGN KEY (product_id) REFERENCES "product" (id) ON UPDATE CASCADE
);

ALTER SEQUENCE order_item_seq RESTART WITH 1;

CREATE UNIQUE INDEX idx_order_item ON order_item (order_id, product_id, type_id);
CREATE INDEX idx_product_id ON order_item (product_id);
CREATE INDEX idx_type_id ON order_item (type_id);



--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.3
-- Dumped by pg_dump version 9.5.3

-- Started on 2016-09-12 08:49:23

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET search_path = public, pg_catalog;

--
-- TOC entry 2148 (class 0 OID 16628)
-- Dependencies: 182
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "user" (id, username, password, auth_key) VALUES (1, 'admin', '$2y$10$Itv.L3qBuloabIbbDjM2D.jfAnYLajpPyYn3kYfoRPRuMYLVN6Egy', 'admin-key');
INSERT INTO "user" (id, username, password, auth_key) VALUES (2, 'demo', '$2y$10$eeP6zIc7gVDQFtGB22.NT.Xt32WoyBHvkzOdAcQ0CpLL0utuM9iv6', 'demo-key');


--
-- TOC entry 2149 (class 0 OID 16634)
-- Dependencies: 183
-- Data for Name: order; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "order" (id, user_id, created_at) VALUES ('57d1cc07d314e', 1, 1473367055);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d1cc6298c76', 2, 1473367152);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d1d3aeb02df', 2, 1473369016);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d23a2447b31', 1, 1473395240);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d240b0cfa8f', 1, 1473396918);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d240ba6cac3', 1, 1473396925);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d24cc557068', 1, 1473400007);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d2512ed276c', 2, 1473401139);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d25cdb7d7d1', 2, 1473404129);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d2b92ba270e', 1, 1473427760);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d3f57745282', 1, 1473508730);
INSERT INTO "order" (id, user_id, created_at) VALUES ('57d422a5d9fa6', 2, 1473520304);


--
-- TOC entry 2151 (class 0 OID 16647)
-- Dependencies: 185
-- Data for Name: product; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO product (id, name) VALUES (1, 'Рабочая тетрадь');
INSERT INTO product (id, name) VALUES (2, 'Ручка');
INSERT INTO product (id, name) VALUES (3, 'Карандаш');


--
-- TOC entry 2156 (class 0 OID 16678)
-- Dependencies: 190
-- Data for Name: order_item; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (76, '57d2512ed276c', 1, 1, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (77, '57d2512ed276c', 1, 2, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (53, '57d1cc07d314e', 1, 1, 5);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (88, '57d3f57745282', 1, 1, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (90, '57d3f57745282', 2, 3, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (89, '57d3f57745282', 3, NULL, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (91, '57d3f57745282', 1, 2, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (92, '57d240b0cfa8f', 2, 4, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (93, '57d1cc07d314e', 3, NULL, 10);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (79, '57d25cdb7d7d1', 2, 4, 35);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (78, '57d25cdb7d7d1', 2, 3, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (94, '57d25cdb7d7d1', 1, 2, 35);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (95, '57d25cdb7d7d1', 1, 1, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (96, '57d25cdb7d7d1', 3, NULL, 35);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (55, '57d1cc6298c76', 2, 3, 5);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (56, '57d1cc6298c76', 2, 4, 10);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (57, '57d1d3aeb02df', 1, 1, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (99, '57d422a5d9fa6', 2, 3, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (100, '57d422a5d9fa6', 1, 2, 35);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (75, '57d24cc557068', 2, 4, 75);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (54, '57d1cc07d314e', 1, 2, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (58, '57d1cc07d314e', 2, 3, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (61, '57d1cc07d314e', 2, 4, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (59, '57d23a2447b31', 2, 4, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (62, '57d23a2447b31', 1, 1, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (80, '57d24cc557068', 3, NULL, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (60, '57d23a2447b31', 1, 2, 30);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (73, '57d24cc557068', 1, 1, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (81, '57d24cc557068', 1, 2, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (74, '57d24cc557068', 2, 3, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (65, '57d240b0cfa8f', 1, 1, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (98, '57d422a5d9fa6', 1, 1, 55);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (97, '57d422a5d9fa6', 3, NULL, 55);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (83, '57d2b92ba270e', 1, 1, 35);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (84, '57d2b92ba270e', 1, 2, 25);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (85, '57d2b92ba270e', 3, NULL, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (86, '57d2b92ba270e', 2, 4, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (67, '57d240ba6cac3', 3, NULL, 15);
INSERT INTO order_item (id, order_id, product_id, type_id, quantity) VALUES (87, '57d240ba6cac3', 2, 3, 15);


--
-- TOC entry 2161 (class 0 OID 0)
-- Dependencies: 189
-- Name: order_item_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('order_item_seq', 105, true);


--
-- TOC entry 2162 (class 0 OID 0)
-- Dependencies: 184
-- Name: product_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('product_seq', 3, true);


--
-- TOC entry 2153 (class 0 OID 16655)
-- Dependencies: 187
-- Data for Name: type; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO type (id, name) VALUES (1, 'в клеточку');
INSERT INTO type (id, name) VALUES (2, 'в строчку');
INSERT INTO type (id, name) VALUES (3, 'синяя паста');
INSERT INTO type (id, name) VALUES (4, 'красная паста');


--
-- TOC entry 2154 (class 0 OID 16661)
-- Dependencies: 188
-- Data for Name: product_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO product_type (product_id, type_id) VALUES (1, 1);
INSERT INTO product_type (product_id, type_id) VALUES (1, 2);
INSERT INTO product_type (product_id, type_id) VALUES (2, 3);
INSERT INTO product_type (product_id, type_id) VALUES (2, 4);


--
-- TOC entry 2163 (class 0 OID 0)
-- Dependencies: 186
-- Name: type_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('type_seq', 4, true);


--
-- TOC entry 2164 (class 0 OID 0)
-- Dependencies: 181
-- Name: user_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('user_seq', 2, true);


-- Completed on 2016-09-12 08:49:23

--
-- PostgreSQL database dump complete
--