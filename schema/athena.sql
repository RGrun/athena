-- --------------------------------------------------------
-- Server-side Schema (MySQL)
--
--  Version 0.0
--  Version 0.1 6/4/14
--
-- --------------------------------------------------------

-- --------------------------------------------------------
-- Sessions
-- --------------------------------------------------------
drop table if exists sessions;
create table if not exists sessions
( sess_id   int(10)      not null auto_increment,
  created   datetime     not null default '0/0/0',   -- date/time of session creation
  touched   datetime     not null default '0/0/0',   -- date/time of last touch
  sid       varchar(40)  not null default '',        -- some obscure hash of the sess_id for the cookie
  primary key (sess_id)
);

-- --------------------------------------------------------
-- Owners of trays and/or teams.
-- --------------------------------------------------------
drop table if exists company;
create table if not exists company
( cmp_id    int(10)      not null auto_increment,
  active    int(1)       not null default 1,
  name      varchar(255) not null default '',
  address   varchar(255) not null default '',
  city      varchar(255) not null default '',
  state     varchar(255) not null default '',
  zip       varchar(255) not null default '',
  primary key (cmp_id)
);

-- --------------------------------------------------------
-- Places that companies store trays
-- --------------------------------------------------------
drop table if exists storage;
create table if not exists storage
( stor_id   int(10)      not null auto_increment,
  cmp_id    int(10)      not null,
  active    int(1)       not null default 1,
  name      varchar(255) not null default '',
  address   varchar(255) not null default '',
  city      varchar(255) not null default '',
  state     varchar(255) not null default '',
  zip       varchar(255) not null default '',
  primary key (stor_id)
);

-- --------------------------------------------------------
-- lenders of trays: individuals on teams that transport
-- trays.
-- --------------------------------------------------------
drop table if exists users;
create table if not exists users 
( usr_id    int(10)      not null auto_increment,
  active    int(1)       not null default 1,
  team_id   int(10)      not null default 0,       -- a user can only be on one team
  fname     varchar(255) not null default '',
  lname     varchar(255) not null default '',
  uname     varchar(36)  not null default '',
  pwd       varchar(36)  not null default '',
  email     varchar(255) not null default '',
  phone     varchar(25)  not null default '',
  sms       varchar(25)  not null default '',
  perm      varchar(80)  not null default '',
  primary key (usr_id)
);

-- --------------------------------------------------------
-- User <> Company map
-- Users can work for multiple companies at the same time
-- --------------------------------------------------------
drop table if exists usr_cmp;
create table if not exists usr_cmp 
( usr_id    int(10)      not null,
  cmp_id    int(10)      not null,
  rel       varchar(20)  not null default "emp",    -- "emp", "dst", "ex", ...
  unique index (usr_id, cmp_id)
);

-- --------------------------------------------------------
-- Distributor <> Company map
-- Companies distribute for other companies
-- --------------------------------------------------------
drop table if exists dst_cmp;
create table if not exists dst_cmp 
( dst_id    int(10)      not null,  -- cmp_id of the distributor
  cmp_id    int(10)      not null,  -- cmp_id of the customer
  unique index (dst_id, cmp_id)
);

-- --------------------------------------------------------
-- places where trays are dropped of and picked up
-- --------------------------------------------------------
drop table if exists sites;
create table if not exists sites 
( site_id   int(10)      not null auto_increment,
  active    int(1)       not null default '1',
  name      varchar(255) not null,
  address   varchar(255) not null,
  city      varchar(255) not null,
  state     varchar(2)   not null,
  zip       varchar(5)   not null,
  fax       varchar(10)  not null,
  unique index (name),
  primary key (site_id)
);

-- --------------------------------------------------------
-- Regions - sites belong to regions
-- --------------------------------------------------------
drop table if exists regions;
create table if not exists regions 
( reg_id    int(10)      not null auto_increment,
  cmp_id    int(10)      not null default 0, 
  name      varchar(255) not null,
  city      varchar(255) not null,
  state     varchar(2)   not null,
  unique index (name),
  primary key (reg_id)
);

-- --------------------------------------------------------
-- Site <> Regions map
-- A site can be in many regions
-- --------------------------------------------------------
drop table if exists site_region;
create table if not exists site_region
( site_id    int(10)      not null,
  cmp_id     int(10)      not null default 0, 
  reg_id     int(10)      not null,
  unique index (site_id, reg_id)
);

-- --------------------------------------------------------
-- borrowers of trays: individuals at sites where trays
-- are dropped off and picked up.
-- --------------------------------------------------------
drop table if exists clients;
create table if not exists clients 
( cli_id    int(10)      not null auto_increment,
  active    int(1)       not null default 1,
  fname     varchar(255) not null default '',
  lname     varchar(255) not null default '',
  uname     varchar(36)  not null default '',
  pwd       varchar(36)  not null default '',
  email     varchar(255) not null default '',
  phone     varchar(25)  not null default '',
  sms       varchar(25)  not null default '',
  perm      varchar(80)  not null default '',
  primary key (cli_id)
);

-- --------------------------------------------------------
-- Client <> Sites map
-- A client might work at multiple sites, we assume that
-- billing can be resolved by site.
-- --------------------------------------------------------
drop table if exists cli_site;
create table if not exists cli_site 
( cli_id    int(10)      not null,
  site_id   int(10)      not null,
  unique index (cli_id, site_id)
);

-- --------------------------------------------------------
-- A group of users that share a set of trays and cases
-- --------------------------------------------------------
drop table if exists teams;
create table if not exists teams 
( team_id   int(10)      not null auto_increment,
  name      varchar(255) not null,
  region    varchar(40)  not null default '',
  state     varchar(3)   not null,
  cmp_id    int(10)      not null default 0,    -- teams are owned by ONE company or distributor
  head_id   int(10)      not null default 0,    -- user responsible for the team
  primary key (team_id)
);

-- --------------------------------------------------------
drop table if exists doctors;
create table if not exists doctors 
( doc_id    int(10)      not null auto_increment,
  active    int(1)       not null default '1',
  name      varchar(255) not null,
  unique index (name),
  primary key (doc_id)
);

-- --------------------------------------------------------
-- Doctor <> Company map
-- A doctor uses trays from a company.
-- --------------------------------------------------------
drop table if exists doc_cmp;
create table if not exists doc_cmp 
( doc_id    int(10)      not null,
  cmp_id    int(10)      not null default 0, 
  unique index (doc_id, cmp_id)
);

-- --------------------------------------------------------
-- Doctor <> Sites map
-- A doctor can work at many sites
-- --------------------------------------------------------
drop table if exists doc_site;
create table if not exists doc_site 
( doc_id    int(10)      not null,
**  cmp_id    int(10)      not null default 0, 
  site_id   int(10)      not null,
  unique index (doc_id, site_id)
);

-- --------------------------------------------------------
-- items that trays can contain.
-- --------------------------------------------------------
drop table if exists instruments;
create table if not exists instruments 
( inst_id   int(10)       not null auto_increment,
  cmp_id    int(10)       not null default 0, 
  name      varchar(255)  not null,                          
  partno    varchar(255)  not null,
  unique index (partno),
  primary key (inst_id)
);

-- --------------------------------------------------------
-- Trays 
-- --------------------------------------------------------
drop table if exists trays;
create table if not exists trays 
( tray_id   int(10)      not null auto_increment,
  name      varchar(255) not null,                   -- tray specific name e.g. T27
  cmp_id    int(10)      not null,                   -- owner of the tray, ultimate owner (not distributor)
  team_id   int(10)      not null,                   -- the team responsible for the tray

                                                ---- dynamic attributes (change based on use)
  atnow     varchar(20)  not null default 'unk',     -- 'usr', 'site', 'stor', unk'       
  usr_id    int(10)      not null default 0,         -- when a user picks up, they are in possession
  site_id   int(10)      not null default 0,         -- current site with possession of the tray
  stor_id   int(10)      not null default 0,         -- company locations that store trays 
  
  
  loan_team int(10)      not null default 0,         -- the team the tray is currently loaned to
  
  -- remove status? 
  -- status    varchar(25)  not null default '',        -- current status of the tray: open, scheduled, loaned, ???
  
  primary key (tray_id)
);

-- --------------------------------------------------------
-- Tray Tags - set of tags that can be assinged to trays
-- and procedures 
-- --------------------------------------------------------
drop table if exists tags;
create table if not exists tags 
( tag      varchar(80)  not null,                   -- tag
  cmp_id   int(10)      not null default 0,         -- 0 if global
  unique index (tag, cmp_id)
);

-- --------------------------------------------------------
-- Tray tag map 
-- --------------------------------------------------------
drop table if exists tray_tag;
create table if not exists tray_tag 
( tray_id   int(10)      not null,
  tag       varchar(80)  not null,
  unique index (tray_id, tag)
);

-- --------------------------------------------------------
-- Tray types, define an abstract tray type that is 
-- a collection of tags. 
-- --------------------------------------------------------
drop table if exists ttyp;
create table if not exists ttyp 
( ttyp_id   int(10)      not null auto_increment,
  name      varchar(255) not null,                   -- tray type name
  cmp_id    int(10)      not null,                   -- are tray types by company or team
  team_id   int(10)      not null,                   -- 
  primary key (ttyp_id)
);

-- --------------------------------------------------------
-- Tray type tag map 
-- --------------------------------------------------------
drop table if exists ttyp_tag;
create table if not exists ttyp_tag 
( ttyp_id   int(10)      not null,
  tag       varchar(80)  not null,
  unique index (ttyp_id, tag)
);

-- --------------------------------------------------------
-- The history of tray's dropped at storage. 
-- --------------------------------------------------------
drop table if exists h_traystor;
create table if not exists h_traystor 
( tray_id   int(10)      not null,
  stor_id   int(10)      not null default 0,         -- 0 means the comany address
  usr_id    int(10)      not null default 0,         -- logged in user that made the change
  dttm      datetime     not null default '0/0/0'  -- date/time of change
);

-- --------------------------------------------------------
-- The actual contents of a specific tray (current)
-- --------------------------------------------------------
drop table if exists traycont;
create table if not exists traycont 
( tray_id   int(10)      not null,
  inst_id   int(10)      not null,
  quant     int(4)       not null default 1,
  state     varchar(20)  not null default 'p',     -- Present, Missing, Removed, Broken, Spent
  cmt       varchar(255) not null default '' ,     -- special information about this instrument for this tray
  unique index (tray_id, inst_id)
);

-- --------------------------------------------------------
-- History of tray transfers to another team. Assumes
-- that the tray is returned when it's picked up
-- at the end of a case. 
-- --------------------------------------------------------
drop table if exists traytrans;
create table if not exists traytrans 
( tran_id   int(10)      not null auto_increment,
  tray_id   int(10)      not null,
  signer    varchar(25)  not null,                   -- name of person who signed for tray during dropoff
  site_id   int(10)      not null,					 -- where tray was dropped off
  from_usr  int(10)      not null default 0,         -- User dropping off tray
  to_usr    int(10)      not null default 0,         -- User assigned to pick up tray
  case_id   int(10)      not null,                   -- the case that requires the tray
  dttm      datetime     not null default '0/0/0',   -- date/time of loan
  primary key (tran_id)
);

-- --------------------------------------------------------
-- The history of tray content changes. 
-- If the change occurs at an assign, then the asgn_id is
-- non-zero. 
-- --------------------------------------------------------
drop table if exists h_traycont;
create table if not exists h_traycont 
( asgn_id   int(10)      not null default 0,       -- after the tray returns from an assignment, the contents may have changed
  tray_id   int(10)      not null,
  inst_id   int(10)      not null,
  quant     int(4)       not null default 1,
  state     varchar(20)  not null default 'p',     -- Missing, Broken, Spent
  cmt       varchar(255) not null default '',  -- description of change from assignment, or other source.
  dttm		datetime	 not null default '0/0/0'
);

-- --------------------------------------------------------
-- Events that require a set of trays, a specific medical
-- procedure ordered by a specific doctor at a specific location
-- --------------------------------------------------------
drop table if exists cases;
create table if not exists cases 
( case_id   int(10)      not null auto_increment,
  team_id   int(10)      not null default 0,         -- team assigned to case (only one team on a case)
  doc_id    int(10)      not null default 0,         -- doctor performing procedure
  proc_id   int(10)      not null default 0,         -- procedure
  site_id   int(10)      not null default 0,         -- site where the trays are dropped
  status    varchar(40)  not null default '',        -- ???
  dttm      datetime     not null default '0/0/0',   -- date/time of procedure
  cmt       varchar(255) not null default '',
  primary key (case_id)
);

-- --------------------------------------------------------
-- 
-- --------------------------------------------------------
drop table if exists case_ttyp;
create table if not exists case_ttyp 
( case_id   int(10)      not null,
  ttyp_id   int(10)      not null, 
  cmt       varchar(255) not null default '',
  tray_id   int(10)      not null default 0,          -- tray that satisfies this type, used to signal that a tray is assigned.
  unique index (case_id, ttyp_id)
);

-- --------------------------------------------------------
-- A case requires a set of 1 or more of trays
-- Every instance of a tray being loadned to a client,
-- actual or pending
-- on_insert, update current tray owner, reservations, ...
-- --------------------------------------------------------
drop table if exists assigns;
create table if not exists assigns 
( asgn_id   int(10)      not null auto_increment,
  case_id   int(10)      not null,
  tray_id   int(10)      not null,
  
  do_usr    int(10)      not null default 0,     -- 0 if pending (any team member can drop or pickup)
  pu_usr    int(10)      not null default 0,     -- 0 if pending (any team member can drop or pickup)
  cli_nm    varchar(64)  not null default '',    -- the name entered in the drop off signature field
  
  do_dttm   datetime     not null,               -- scheduled or actual
  pu_dttm   datetime     not null,               -- scheduled or actual
  status    varchar(25)  not null default '',    -- pending, overdue or complete
  cmt       varchar(255) not null default '',
  primary key (asgn_id)
);

-- --------------------------------------------------------
-- stores the history of assigning users to assignments
-- --------------------------------------------------------
drop table if exists h_assigns;
create table if not exists h_assigns 
( h_asgn_id int(10)      not null auto_increment,
  asgn_id   int(10)      not null,
  action    varchar(20)  not null,                  --  "do", "pu"
  status    varchar(20)  not null default 'pending' --  "pending", "accepted", "rejected", "relinquished"
  from_usr  int(10)      not null,                  -- user initiating this action
  to_usr    int(10)      not null,                  -- user targeted (given)
  dttm      datetime     not null,                  -- dttm when action initiated
  primary key (h_asgn_id)
);

-- --------------------------------------------------------
-- a medical procedure requiring a set of instruments
-- a user defines procs based on the instruments and
-- surgeries needed for their sites and doctors.
-- the system can then search for the minimum set of trays
-- needed to satisfy a proc
-- --------------------------------------------------------
drop table if exists procs;
create table if not exists procs 
( proc_id   int(10)       not null auto_increment,
  cmp_id    int(10)       not null default 0,         -- 0 if global
  name      varchar(255)  not null,
  primary key (proc_id)
);

-- --------------------------------------------------------
-- Procedure tag map 
-- --------------------------------------------------------
drop table if exists proc_tag;
create table if not exists proc_tag 
( proc_id   int(10)      not null,
  tag       varchar(80)  not null,
  unique index (tag, proc_id)
);

-- --------------------------------------------------------
DELETE THIS TABLE
-- maps the instruments required for a proc
-- --------------------------------------------------------
drop table if exists proc_inst;
create table if not exists proc_inst 
( proc_id   int(10)      not null,
  inst_id   int(10)      not null,
  quant     int(4)       not null default 1,
  unique index (proc_id, inst_id)
);

-- --------------------------------------------------------
-- Notifications for the user. 
-- --------------------------------------------------------
drop table if exists unotifs;
create table if not exis ts unotifs 
( un_id     int(10)       not null auto_increment
  usr_id    int(10)       not null,
  hidden    int(10)       not null default 0,     -- set to 1 after the notification should be hidden
  msg       varchar(255)  not null,                
  dttm      datetime      not null,               -- the dttm the notification was generated
  evdttm    datetime      not null,               -- the dttm of the event related to the notification
  vwdttm    datetime      not null,               -- the last dttm the notification was viewed
  primary key(un_id)
);

-- --------------------------------------------------------
-- When a user or a client requests a password change
-- --------------------------------------------------------
drop table if exists pwdresets;
create table if not exists pwdresets
( rst_id    int(10)      not null auto_increment,
  id        int(10)      not null,                  -- the primary key of the user typ
  typ       int(1)       not null,                  -- which kind of user
  status    varchar(20)  not null default 'new',
  code      varchar(25)  not null,
  dttm      datetime     not null,
  primary key (rst_id)
);

-- --------------------------------------------------------
-- System events
--
--  u_id = '1234'            // the user id who is logged in when the event happened.
--  name = 'assign.pu_date'  // each event has it's own name
--  info = 'from=2014-06-22 to=2014-06-23'
--
--  u_id = '0'              
--  name = 'login.failure'  
--  info = 'user=testuser'
-- --------------------------------------------------------
drop table if exists sevents;
create table if not exists sevents
( evt_id    int(10)        not null auto_increment,
  u_id      int(10)        not null,                  -- the primary key of the user typ
  name      varchar(20)    not null,                  -- which event happened
  item      varchar(512)   not null,                  -- information for each event
  was       varchar(512)   not null,                  -- information for each event
  now       varchar(512)   not null,                  -- information for each event
  dttm      datetime       not null,                  -- the dttm that the event happened
  primary key (evt_id)
);

-- ----------------------------------------------------------------------------------
-- Commands to build database
-- ----------------------------------------------------------------------------------
-- create database athena;
-- use athena;
-- GRANT ALL ON athena.* TO 'athena'@'localhost' identified by 'abcd1234';
-- ----------------------------------------------------------------------------------

