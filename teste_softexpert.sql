--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: comercial; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA comercial;


ALTER SCHEMA comercial OWNER TO postgres;

--
-- Name: produto; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA produto;


ALTER SCHEMA produto OWNER TO postgres;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: produto_venda; Type: TABLE; Schema: comercial; Owner: postgres
--

CREATE TABLE comercial.produto_venda (
    id integer NOT NULL,
    produto_id integer NOT NULL,
    venda_id integer NOT NULL,
    quantidade integer NOT NULL,
    "logCadastroData" timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE comercial.produto_venda OWNER TO postgres;

--
-- Name: produto_venda_id_seq; Type: SEQUENCE; Schema: comercial; Owner: postgres
--

CREATE SEQUENCE comercial.produto_venda_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE comercial.produto_venda_id_seq OWNER TO postgres;

--
-- Name: produto_venda_id_seq; Type: SEQUENCE OWNED BY; Schema: comercial; Owner: postgres
--

ALTER SEQUENCE comercial.produto_venda_id_seq OWNED BY comercial.produto_venda.id;


--
-- Name: venda; Type: TABLE; Schema: comercial; Owner: postgres
--

CREATE TABLE comercial.venda (
    id integer NOT NULL,
    "logCadastroData" timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    concluida boolean DEFAULT false
);


ALTER TABLE comercial.venda OWNER TO postgres;

--
-- Name: venda_id_seq; Type: SEQUENCE; Schema: comercial; Owner: postgres
--

CREATE SEQUENCE comercial.venda_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE comercial.venda_id_seq OWNER TO postgres;

--
-- Name: venda_id_seq; Type: SEQUENCE OWNED BY; Schema: comercial; Owner: postgres
--

ALTER SEQUENCE comercial.venda_id_seq OWNED BY comercial.venda.id;


--
-- Name: produto; Type: TABLE; Schema: produto; Owner: postgres
--

CREATE TABLE produto.produto (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    tipo_id integer NOT NULL,
    "logCadastroData" timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    "logAtualizadoData" timestamp with time zone,
    valor numeric NOT NULL
);


ALTER TABLE produto.produto OWNER TO postgres;

--
-- Name: produto_id_seq; Type: SEQUENCE; Schema: produto; Owner: postgres
--

CREATE SEQUENCE produto.produto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE produto.produto_id_seq OWNER TO postgres;

--
-- Name: produto_id_seq; Type: SEQUENCE OWNED BY; Schema: produto; Owner: postgres
--

ALTER SEQUENCE produto.produto_id_seq OWNED BY produto.produto.id;


--
-- Name: tipo; Type: TABLE; Schema: produto; Owner: postgres
--

CREATE TABLE produto.tipo (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    imposto numeric NOT NULL,
    "logCadastroData" timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    "logAtualizadoData" timestamp with time zone
);


ALTER TABLE produto.tipo OWNER TO postgres;

--
-- Name: tipo_id_seq; Type: SEQUENCE; Schema: produto; Owner: postgres
--

CREATE SEQUENCE produto.tipo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE produto.tipo_id_seq OWNER TO postgres;

--
-- Name: tipo_id_seq; Type: SEQUENCE OWNED BY; Schema: produto; Owner: postgres
--

ALTER SEQUENCE produto.tipo_id_seq OWNED BY produto.tipo.id;


--
-- Name: produto_venda id; Type: DEFAULT; Schema: comercial; Owner: postgres
--

ALTER TABLE ONLY comercial.produto_venda ALTER COLUMN id SET DEFAULT nextval('comercial.produto_venda_id_seq'::regclass);


--
-- Name: venda id; Type: DEFAULT; Schema: comercial; Owner: postgres
--

ALTER TABLE ONLY comercial.venda ALTER COLUMN id SET DEFAULT nextval('comercial.venda_id_seq'::regclass);


--
-- Name: produto id; Type: DEFAULT; Schema: produto; Owner: postgres
--

ALTER TABLE ONLY produto.produto ALTER COLUMN id SET DEFAULT nextval('produto.produto_id_seq'::regclass);


--
-- Name: tipo id; Type: DEFAULT; Schema: produto; Owner: postgres
--

ALTER TABLE ONLY produto.tipo ALTER COLUMN id SET DEFAULT nextval('produto.tipo_id_seq'::regclass);


--
-- Name: produto_venda produto_venda_pkey; Type: CONSTRAINT; Schema: comercial; Owner: postgres
--

ALTER TABLE ONLY comercial.produto_venda
    ADD CONSTRAINT produto_venda_pkey PRIMARY KEY (id);


--
-- Name: venda venda_pkey; Type: CONSTRAINT; Schema: comercial; Owner: postgres
--

ALTER TABLE ONLY comercial.venda
    ADD CONSTRAINT venda_pkey PRIMARY KEY (id);


--
-- Name: produto produto_pkey; Type: CONSTRAINT; Schema: produto; Owner: postgres
--

ALTER TABLE ONLY produto.produto
    ADD CONSTRAINT produto_pkey PRIMARY KEY (id);


--
-- Name: tipo tipo_pkey; Type: CONSTRAINT; Schema: produto; Owner: postgres
--

ALTER TABLE ONLY produto.tipo
    ADD CONSTRAINT tipo_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

