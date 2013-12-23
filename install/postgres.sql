--
-- PostgreSQL database dump
--

-- Started on 2013-12-23 23:57:34

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 1795 (class 1262 OID 26862)
-- Name: requestable; Type: DATABASE; Schema: -; Owner: someuser
--

CREATE DATABASE requestable WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'nl_NL.utf8' LC_CTYPE = 'nl_NL.utf8';


ALTER DATABASE requestable OWNER TO someuser;

\connect requestable

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 310 (class 2612 OID 16386)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1501 (class 1259 OID 26894)
-- Dependencies: 3
-- Name: requestheaders; Type: TABLE; Schema: public; Owner: someuser; Tablespace: 
--

CREATE TABLE requestheaders (
    id bigint NOT NULL,
    requestid bigint NOT NULL,
    header character varying(128) NOT NULL
);


ALTER TABLE public.requestheaders OWNER TO someuser;

--
-- TOC entry 1499 (class 1259 OID 26890)
-- Dependencies: 1501 3
-- Name: requestheaders_id_seq; Type: SEQUENCE; Schema: public; Owner: someuser
--

CREATE SEQUENCE requestheaders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.requestheaders_id_seq OWNER TO someuser;

--
-- TOC entry 1798 (class 0 OID 0)
-- Dependencies: 1499
-- Name: requestheaders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: someuser
--

ALTER SEQUENCE requestheaders_id_seq OWNED BY requestheaders.id;


--
-- TOC entry 1500 (class 1259 OID 26892)
-- Dependencies: 3 1501
-- Name: requestheaders_requestid_seq; Type: SEQUENCE; Schema: public; Owner: someuser
--

CREATE SEQUENCE requestheaders_requestid_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.requestheaders_requestid_seq OWNER TO someuser;

--
-- TOC entry 1799 (class 0 OID 0)
-- Dependencies: 1500
-- Name: requestheaders_requestid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: someuser
--

ALTER SEQUENCE requestheaders_requestid_seq OWNED BY requestheaders.requestid;


--
-- TOC entry 1498 (class 1259 OID 26871)
-- Dependencies: 1780 1781 1782 1783 1784 1785 3
-- Name: requests; Type: TABLE; Schema: public; Owner: someuser; Tablespace: 
--

CREATE TABLE requests (
    id bigint NOT NULL,
    uri character varying(255) NOT NULL,
    method character varying(128) NOT NULL,
    follow boolean DEFAULT false NOT NULL,
    cookies boolean DEFAULT false NOT NULL,
    body text,
    version character varying(10) DEFAULT '1.1'::character varying NOT NULL,
    verifypeer boolean DEFAULT false NOT NULL,
    verifyhost boolean DEFAULT false NOT NULL,
    sslversion character varying(10) DEFAULT 'automatic'::character varying NOT NULL,
    cabundle character(40)
);


ALTER TABLE public.requests OWNER TO someuser;

--
-- TOC entry 1497 (class 1259 OID 26869)
-- Dependencies: 1498 3
-- Name: requests_id_seq; Type: SEQUENCE; Schema: public; Owner: someuser
--

CREATE SEQUENCE requests_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.requests_id_seq OWNER TO someuser;

--
-- TOC entry 1800 (class 0 OID 0)
-- Dependencies: 1497
-- Name: requests_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: someuser
--

ALTER SEQUENCE requests_id_seq OWNED BY requests.id;


--
-- TOC entry 1786 (class 2604 OID 26897)
-- Dependencies: 1499 1501 1501
-- Name: id; Type: DEFAULT; Schema: public; Owner: someuser
--

ALTER TABLE requestheaders ALTER COLUMN id SET DEFAULT nextval('requestheaders_id_seq'::regclass);


--
-- TOC entry 1787 (class 2604 OID 26898)
-- Dependencies: 1501 1500 1501
-- Name: requestid; Type: DEFAULT; Schema: public; Owner: someuser
--

ALTER TABLE requestheaders ALTER COLUMN requestid SET DEFAULT nextval('requestheaders_requestid_seq'::regclass);


--
-- TOC entry 1779 (class 2604 OID 26874)
-- Dependencies: 1497 1498 1498
-- Name: id; Type: DEFAULT; Schema: public; Owner: someuser
--

ALTER TABLE requests ALTER COLUMN id SET DEFAULT nextval('requests_id_seq'::regclass);


--
-- TOC entry 1791 (class 2606 OID 26900)
-- Dependencies: 1501 1501
-- Name: pk_requestheaders; Type: CONSTRAINT; Schema: public; Owner: someuser; Tablespace: 
--

ALTER TABLE ONLY requestheaders
    ADD CONSTRAINT pk_requestheaders PRIMARY KEY (id);


--
-- TOC entry 1789 (class 2606 OID 26876)
-- Dependencies: 1498 1498
-- Name: pk_requests; Type: CONSTRAINT; Schema: public; Owner: someuser; Tablespace: 
--

ALTER TABLE ONLY requests
    ADD CONSTRAINT pk_requests PRIMARY KEY (id);


--
-- TOC entry 1792 (class 2606 OID 26901)
-- Dependencies: 1788 1501 1498
-- Name: fk_requestheaders_request; Type: FK CONSTRAINT; Schema: public; Owner: someuser
--

ALTER TABLE ONLY requestheaders
    ADD CONSTRAINT fk_requestheaders_request FOREIGN KEY (requestid) REFERENCES requests(id);


--
-- TOC entry 1797 (class 0 OID 0)
-- Dependencies: 3
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2013-12-23 23:57:35

--
-- PostgreSQL database dump complete
--

