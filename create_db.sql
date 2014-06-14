--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: pb305049; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA pb305049;


SET search_path = pb305049, pg_catalog;

--
-- Name: delete_election(integer); Type: FUNCTION; Schema: pb305049; Owner: -
--

CREATE FUNCTION delete_election(p_idelection integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
DELETE FROM vote WHERE idelection = p_idelection; 
DELETE FROM candidate WHERE idelection = p_idelection;
DELETE FROM election WHERE idelection = p_idelection;
RETURN;
END; 
$$;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: candidate; Type: TABLE; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE TABLE candidate (
    idcandidate integer NOT NULL,
    idelection integer NOT NULL,
    name character varying,
    surname character varying
);


--
-- Name: candidate_idcandidate_seq; Type: SEQUENCE; Schema: pb305049; Owner: -
--

CREATE SEQUENCE candidate_idcandidate_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: candidate_idcandidate_seq; Type: SEQUENCE OWNED BY; Schema: pb305049; Owner: -
--

ALTER SEQUENCE candidate_idcandidate_seq OWNED BY candidate.idcandidate;


--
-- Name: election; Type: TABLE; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE TABLE election (
    idelection integer NOT NULL,
    name character varying,
    no_pos integer,
    reg_deadline timestamp without time zone,
    start_time timestamp without time zone,
    end_time timestamp without time zone,
    results_published boolean,
    CONSTRAINT date_order_election CHECK (((reg_deadline <= start_time) AND (start_time <= end_time))),
    CONSTRAINT pos_no_pos CHECK ((no_pos > 0))
);


--
-- Name: election_idelection_seq; Type: SEQUENCE; Schema: pb305049; Owner: -
--

CREATE SEQUENCE election_idelection_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: election_idelection_seq; Type: SEQUENCE OWNED BY; Schema: pb305049; Owner: -
--

ALTER SEQUENCE election_idelection_seq OWNED BY election.idelection;


--
-- Name: user_; Type: TABLE; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE TABLE user_ (
    iduser_ integer NOT NULL,
    idusertype integer,
    login character varying,
    pass_hash character varying
);


--
-- Name: user__iduser__seq; Type: SEQUENCE; Schema: pb305049; Owner: -
--

CREATE SEQUENCE user__iduser__seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: user__iduser__seq; Type: SEQUENCE OWNED BY; Schema: pb305049; Owner: -
--

ALTER SEQUENCE user__iduser__seq OWNED BY user_.iduser_;


--
-- Name: usertype; Type: TABLE; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE TABLE usertype (
    idusertype integer NOT NULL,
    name character varying
);


--
-- Name: usertype_idusertype_seq; Type: SEQUENCE; Schema: pb305049; Owner: -
--

CREATE SEQUENCE usertype_idusertype_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: usertype_idusertype_seq; Type: SEQUENCE OWNED BY; Schema: pb305049; Owner: -
--

ALTER SEQUENCE usertype_idusertype_seq OWNED BY usertype.idusertype;


--
-- Name: vote; Type: TABLE; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE TABLE vote (
    idvote integer NOT NULL,
    iduser_ integer,
    idelection integer,
    idcandidate integer,
    "time" timestamp without time zone
);


--
-- Name: vote_idvote_seq; Type: SEQUENCE; Schema: pb305049; Owner: -
--

CREATE SEQUENCE vote_idvote_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: vote_idvote_seq; Type: SEQUENCE OWNED BY; Schema: pb305049; Owner: -
--

ALTER SEQUENCE vote_idvote_seq OWNED BY vote.idvote;


--
-- Name: idcandidate; Type: DEFAULT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY candidate ALTER COLUMN idcandidate SET DEFAULT nextval('candidate_idcandidate_seq'::regclass);


--
-- Name: idelection; Type: DEFAULT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY election ALTER COLUMN idelection SET DEFAULT nextval('election_idelection_seq'::regclass);


--
-- Name: iduser_; Type: DEFAULT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY user_ ALTER COLUMN iduser_ SET DEFAULT nextval('user__iduser__seq'::regclass);


--
-- Name: idusertype; Type: DEFAULT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY usertype ALTER COLUMN idusertype SET DEFAULT nextval('usertype_idusertype_seq'::regclass);


--
-- Name: idvote; Type: DEFAULT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY vote ALTER COLUMN idvote SET DEFAULT nextval('vote_idvote_seq'::regclass);


--
-- Name: election_pkey; Type: CONSTRAINT; Schema: pb305049; Owner: -; Tablespace: 
--

ALTER TABLE ONLY election
    ADD CONSTRAINT election_pkey PRIMARY KEY (idelection);


--
-- Name: pk_candidate; Type: CONSTRAINT; Schema: pb305049; Owner: -; Tablespace: 
--

ALTER TABLE ONLY candidate
    ADD CONSTRAINT pk_candidate PRIMARY KEY (idcandidate);


--
-- Name: pk_user; Type: CONSTRAINT; Schema: pb305049; Owner: -; Tablespace: 
--

ALTER TABLE ONLY user_
    ADD CONSTRAINT pk_user PRIMARY KEY (iduser_);


--
-- Name: pk_vote; Type: CONSTRAINT; Schema: pb305049; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT pk_vote PRIMARY KEY (idvote);


--
-- Name: unq_idelection_name_surname; Type: CONSTRAINT; Schema: pb305049; Owner: -; Tablespace: 
--

ALTER TABLE ONLY candidate
    ADD CONSTRAINT unq_idelection_name_surname UNIQUE (idelection, name, surname);


--
-- Name: unq_login; Type: CONSTRAINT; Schema: pb305049; Owner: -; Tablespace: 
--

ALTER TABLE ONLY user_
    ADD CONSTRAINT unq_login UNIQUE (login);


--
-- Name: unq_user__election; Type: CONSTRAINT; Schema: pb305049; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT unq_user__election UNIQUE (iduser_, idelection);


--
-- Name: usertype_pkey; Type: CONSTRAINT; Schema: pb305049; Owner: -; Tablespace: 
--

ALTER TABLE ONLY usertype
    ADD CONSTRAINT usertype_pkey PRIMARY KEY (idusertype);


--
-- Name: candidate_fkindex1; Type: INDEX; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE INDEX candidate_fkindex1 ON candidate USING btree (idelection);


--
-- Name: user__fkindex1; Type: INDEX; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE INDEX user__fkindex1 ON user_ USING btree (idusertype);


--
-- Name: vote_fkindex1; Type: INDEX; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE INDEX vote_fkindex1 ON vote USING btree (iduser_);


--
-- Name: vote_fkindex2; Type: INDEX; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE INDEX vote_fkindex2 ON vote USING btree (idelection);


--
-- Name: vote_fkindex3; Type: INDEX; Schema: pb305049; Owner: -; Tablespace: 
--

CREATE INDEX vote_fkindex3 ON vote USING btree (idcandidate);


--
-- Name: fk_candidate; Type: FK CONSTRAINT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT fk_candidate FOREIGN KEY (idcandidate) REFERENCES candidate(idcandidate);


--
-- Name: fk_election; Type: FK CONSTRAINT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY candidate
    ADD CONSTRAINT fk_election FOREIGN KEY (idelection) REFERENCES election(idelection);


--
-- Name: fk_election; Type: FK CONSTRAINT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT fk_election FOREIGN KEY (idelection) REFERENCES election(idelection);


--
-- Name: fk_user_; Type: FK CONSTRAINT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT fk_user_ FOREIGN KEY (iduser_) REFERENCES user_(iduser_);


--
-- Name: fk_usertype; Type: FK CONSTRAINT; Schema: pb305049; Owner: -
--

ALTER TABLE ONLY user_
    ADD CONSTRAINT fk_usertype FOREIGN KEY (idusertype) REFERENCES usertype(idusertype);


--
-- PostgreSQL database dump complete
--

