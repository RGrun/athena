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
-- Doctor <> Sites map
-- A doctor can work at many sites
-- --------------------------------------------------------
drop table if exists doc_site;
create table if not exists doc_site 
( doc_id    int(10)      not null,
  site_id   int(10)      not null,
  unique index (doc_id, site_id)
);

-- --------------------------------------------------------
-- items that trays can contain.
-- --------------------------------------------------------
drop table if exists instruments;
create table if not exists instruments 
( inst_id   int(10)       not null auto_increment,
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
  site_id   int(10)      not null default 0,         -- current site with possession of the tray
  loan_team int(10)      not null default 0,         -- the team the tray is currently loaned to
  status    varchar(25)  not null default '',        -- current status of the tray: open, scheduled, loaned, ???
  
  primary key (tray_id)
);

-- --------------------------------------------------------
-- The actual contents of a specific tray (current)
-- --------------------------------------------------------
drop table if exists traycont;
create table if not exists traycont 
( tray_id   int(10)      not null,
  inst_id   int(10)      not null,
  quant     int(4)       not null default 1,
  state     varchar(20)  not null default 'p'     -- Present, Missing, Removed, Broken, Spent
  cmt       varchar(255) not null default ''      -- special information about this instrument for this tray
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
  to_team   int(10)      not null,                   -- the team borrowing the tray
  from_usr  int(10)      not null default 0,         -- 0 if pending (any team member can drop or pickup)
  to_usr    int(10)      not null default 0,         -- 0 if pending (any team member can receive or release)
  case_id   int(10)      not null,                   -- the case that requires the tray
  status    varchar(25)  not null default '',        -- pending, delivered, overdue, complete, ...
  dttm      datetime     not null default '0/0/0',   -- date/time of loan
  cmt       varchar(255) not null default '',
  primary key (tran_id)
);

-- --------------------------------------------------------
-- The history of tray content changes. 
-- If the change occurs at an assign, then the asgn_id is
-- non-zero. 
-- --------------------------------------------------------
drop table if exists traydelta;
create table if not exists traydelta 
( asgn_id   int(10)      not null default 0,       -- after the tray returns from an assignment, the contents may have changed
  tray_id   int(10)      not null,
  inst_id   int(10)      not null,
  quant     int(4)       not null default 1,
  state     varchar(20)  not null default 'p',     -- Missing, Broken, Spent
  cmt       varchar(255) not null default ''       -- description of change from assignment, or other source.
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
-- a medical procedure requiring a set of instruments
-- a user defines procs based on the instruments and
-- surgeries needed for their sites and doctors.
-- the system can then search for the minimum set of trays
-- needed to satisfy a proc
-- --------------------------------------------------------
drop table if exists procs;
create table if not exists procs 
( proc_id   int(10)       not null auto_increment,
  name      varchar(255)  not null,
  primary key (proc_id)
);

-- --------------------------------------------------------
-- maps the instruments required for a proc
-- --------------------------------------------------------
drop table if exists procinsts;
create table if not exists procinsts 
( proc_id   int(10)      not null,
  inst_id   int(10)      not null,
  quant     int(4)       not null default 1,
  unique index (proc_id, inst_id)
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

-- ----------------------------------------------------------------------------------
-- Commands to build database
-- ----------------------------------------------------------------------------------
-- create database athena;
-- use athena;
-- GRANT ALL ON athena.* TO 'athena'@'localhost' identified by 'abcd1234';
-- ----------------------------------------------------------------------------------
