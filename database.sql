--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2 (Debian 16.2-1.pgdg120+2)
-- Dumped by pg_dump version 16.2

-- Started on 2024-06-13 21:39:39 UTC

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
-- TOC entry 234 (class 1255 OID 16485)
-- Name: attend(integer, integer); Type: PROCEDURE; Schema: public; Owner: docker
--

CREATE PROCEDURE public.attend(IN event_id integer, IN user_id integer)
    LANGUAGE sql
    AS $$SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED;

SELECT * FROM public.attendance WHERE id_event = event_id FOR UPDATE;

UPDATE public.events e SET enroled=enroled+1 WHERE e.id = event_id;
INSERT INTO public.attendance (id_user, id_event) VALUES (user_id, event_id);

$$;


ALTER PROCEDURE public.attend(IN event_id integer, IN user_id integer) OWNER TO docker;

--
-- TOC entry 236 (class 1255 OID 16484)
-- Name: cancel(integer, integer); Type: PROCEDURE; Schema: public; Owner: docker
--

CREATE PROCEDURE public.cancel(IN event_id integer, IN user_id integer)
    LANGUAGE sql
    AS $$SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED;

SELECT * FROM public.events WHERE id = event_id FOR UPDATE;

UPDATE public.events SET enroled=enroled-1 WHERE id = event_id;
DELETE FROM public.attendance WHERE id_event = event_id AND id_user = user_id;$$;


ALTER PROCEDURE public.cancel(IN event_id integer, IN user_id integer) OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 218 (class 1259 OID 16418)
-- Name: attendance; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.attendance (
    id_user integer NOT NULL,
    id_event integer NOT NULL
);


ALTER TABLE public.attendance OWNER TO docker;

--
-- TOC entry 235 (class 1255 OID 16493)
-- Name: is_your_event(integer, integer); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.is_your_event(event_id integer, user_id integer) RETURNS integer
    LANGUAGE sql
    RETURN (SELECT 1 FROM public.attendance WHERE ((attendance.id_event = is_your_event.event_id) AND (attendance.id_user = is_your_event.user_id)));


ALTER FUNCTION public.is_your_event(event_id integer, user_id integer) OWNER TO docker;

--
-- TOC entry 216 (class 1259 OID 16394)
-- Name: details; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.details (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL
);


ALTER TABLE public.details OWNER TO docker;

--
-- TOC entry 221 (class 1259 OID 16441)
-- Name: detailspk; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.detailspk
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detailspk OWNER TO docker;

--
-- TOC entry 3400 (class 0 OID 0)
-- Dependencies: 221
-- Name: detailspk; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.detailspk OWNED BY public.details.id;


--
-- TOC entry 219 (class 1259 OID 16428)
-- Name: events; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.events (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255),
    address character varying(255) NOT NULL,
    city character varying(255) NOT NULL,
    zipcode character varying(255) NOT NULL,
    date character varying(255) NOT NULL,
    hour character varying(255) NOT NULL,
    enroled integer DEFAULT 0,
    maxslots integer NOT NULL,
    image character varying(255)
);


ALTER TABLE public.events OWNER TO docker;

--
-- TOC entry 222 (class 1259 OID 16442)
-- Name: eventspk; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.eventspk
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.eventspk OWNER TO docker;

--
-- TOC entry 3401 (class 0 OID 0)
-- Dependencies: 222
-- Name: eventspk; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.eventspk OWNED BY public.events.id;


--
-- TOC entry 215 (class 1259 OID 16389)
-- Name: permissions; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.permissions (
    id integer NOT NULL,
    role character varying(255) NOT NULL
);


ALTER TABLE public.permissions OWNER TO docker;

--
-- TOC entry 217 (class 1259 OID 16401)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    id integer NOT NULL,
    firstname character varying(255) NOT NULL,
    lastname character varying(255) NOT NULL,
    university character varying(255) DEFAULT ' '::character varying,
    role integer DEFAULT 2,
    detail integer NOT NULL
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 220 (class 1259 OID 16440)
-- Name: userpk; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.userpk
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.userpk OWNER TO docker;

--
-- TOC entry 3402 (class 0 OID 0)
-- Dependencies: 220
-- Name: userpk; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.userpk OWNED BY public.users.id;


--
-- TOC entry 3224 (class 2604 OID 16444)
-- Name: details id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.details ALTER COLUMN id SET DEFAULT nextval('public.detailspk'::regclass);


--
-- TOC entry 3228 (class 2604 OID 16445)
-- Name: events id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.eventspk'::regclass);


--
-- TOC entry 3225 (class 2604 OID 16443)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.userpk'::regclass);


--
-- TOC entry 3390 (class 0 OID 16418)
-- Dependencies: 218
-- Data for Name: attendance; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.attendance VALUES (3, 27);
INSERT INTO public.attendance VALUES (5, 25);
INSERT INTO public.attendance VALUES (5, 28);
INSERT INTO public.attendance VALUES (12, 28);
INSERT INTO public.attendance VALUES (12, 29);
INSERT INTO public.attendance VALUES (12, 26);
INSERT INTO public.attendance VALUES (12, 24);
INSERT INTO public.attendance VALUES (11, 24);
INSERT INTO public.attendance VALUES (11, 28);


--
-- TOC entry 3388 (class 0 OID 16394)
-- Dependencies: 216
-- Data for Name: details; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.details VALUES (1, 'admin@unilink.com', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO public.details VALUES (2, 'guest@unilink.com', '084e0343a0486ff05530df6c705c8bb4');
INSERT INTO public.details VALUES (3, 'dawid.kapcia@student.pk.edu.pl', 'c7424b4f43a592c9939b17c9e60f3ea9');
INSERT INTO public.details VALUES (8, 'michal.konieczny@student.uek.edu.pl', '82d73ec2ee332b4c4000a169c82e78b4');
INSERT INTO public.details VALUES (9, 'monika.niedzwiedz@agh.edu.pl', '2511e92279fa324a1d6c9b41f1be86d2');


--
-- TOC entry 3391 (class 0 OID 16428)
-- Dependencies: 219
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.events VALUES (23, 'Volleyball match', 'A quick volleyball game on the beach.', 'ul. Szkolna 54', 'Katowice', '40-002', '2024-06-17', '11:00', 0, 10, 'zpcfjyydwbmfjdyvkvey-1156659370.jpg');
INSERT INTO public.events VALUES (27, 'Learning algebra together', 'Learning in the lecture hall of the Cracow University of Technology.', 'ul. Warszawska 24', 'Kraków', '31-155', '2024-06-23', '9:00', 1, 1, 'Algebra liniowa i geometria analityczna.jpg');
INSERT INTO public.events VALUES (25, 'Chess tournament', 'Amateur chess tournament', 'os. Arka', 'Kraków', '31-456', '2024-06-16', '12:00', 1, 2, 'ChessSet.jpg');
INSERT INTO public.events VALUES (29, 'Transfer to Wroclaw', 'I can take up to three people with me.', 'plac Wolności 1, 50-071', 'Wrocław', '50-071', '2024-07-27', '6:00', 1, 3, 'images (1).jpg');
INSERT INTO public.events VALUES (26, 'Movie night', 'This time on the screen: Interstellar, The Martian.', 'ul. Floriańska', 'Kraków', '31-001', '2024-06-21', '22:00', 1, 15, 'cinema-rex.jpg');
INSERT INTO public.events VALUES (24, 'NBA on the big screen', 'Watching an NBA game together in an academic cinema hall.', 'ul. Warszawska 11', 'Kraków', '31-155', '2024-06-18', '22:00', 2, 20, 'images.jpg');
INSERT INTO public.events VALUES (28, 'Going out for fast food', 'A quick way out for good burgers.', 'al. Jana Pawła II 82', 'Warszawa', '00-175', '2024-06-27', '13:00', 3, 5, 'fast_food-e1653901131973.jpg');


--
-- TOC entry 3387 (class 0 OID 16389)
-- Dependencies: 215
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.permissions VALUES (1, 'Admin');
INSERT INTO public.permissions VALUES (2, 'Registered');
INSERT INTO public.permissions VALUES (3, 'Guest');


--
-- TOC entry 3389 (class 0 OID 16401)
-- Dependencies: 217
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.users VALUES (5, 'Dawid', 'Kapcia', 'Politechnika Krakowska', 2, 3);
INSERT INTO public.users VALUES (3, 'Admin', 'Account', ' ', 1, 1);
INSERT INTO public.users VALUES (4, 'Guest', 'Account', ' ', 3, 2);
INSERT INTO public.users VALUES (12, 'Monika', 'Niedźwiedź', 'AGH UST', 2, 9);
INSERT INTO public.users VALUES (11, 'Michal', 'Konieczny', 'Uniwersytet Ekonomiczny', 2, 8);


--
-- TOC entry 3403 (class 0 OID 0)
-- Dependencies: 221
-- Name: detailspk; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.detailspk', 9, true);


--
-- TOC entry 3404 (class 0 OID 0)
-- Dependencies: 222
-- Name: eventspk; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.eventspk', 29, true);


--
-- TOC entry 3405 (class 0 OID 0)
-- Dependencies: 220
-- Name: userpk; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.userpk', 12, true);


--
-- TOC entry 3237 (class 2606 OID 16422)
-- Name: attendance attendance_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT attendance_pkey PRIMARY KEY (id_user, id_event);


--
-- TOC entry 3233 (class 2606 OID 16400)
-- Name: details details_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.details
    ADD CONSTRAINT details_pkey PRIMARY KEY (id);


--
-- TOC entry 3239 (class 2606 OID 16434)
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- TOC entry 3231 (class 2606 OID 16393)
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- TOC entry 3235 (class 2606 OID 16407)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3240 (class 2606 OID 16408)
-- Name: users FK 1; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "FK 1" FOREIGN KEY (role) REFERENCES public.permissions(id) NOT VALID;


--
-- TOC entry 3242 (class 2606 OID 16494)
-- Name: attendance FK 1; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT "FK 1" FOREIGN KEY (id_user) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3243 (class 2606 OID 16486)
-- Name: attendance FK 2; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT "FK 2" FOREIGN KEY (id_event) REFERENCES public.events(id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3241 (class 2606 OID 16499)
-- Name: users FK 2; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "FK 2" FOREIGN KEY (detail) REFERENCES public.details(id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


-- Completed on 2024-06-13 21:39:39 UTC

--
-- PostgreSQL database dump complete
--

