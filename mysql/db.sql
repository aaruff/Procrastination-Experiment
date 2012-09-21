use pro_one_task;

drop table if exists experimenter;
create table experimenter(
  id		integer auto_increment primary key,
  login 	varchar(100) null,
  password 	varchar(100) null
) ENGINE=InnoDB;

insert into experimenter(login, password) values
	('Kyle', 'kyle0011');
insert into experimenter(login, password) values
 	('admin', 'cess01cess');


drop table if exists subject;
create table subject(
  id				integer auto_increment primary key,
  login				varchar(100) default null,
  password			varchar(100) default null,
  email 			varchar(100) default null,
  treatment_id		integer not null,
  survey_status	    enum('unregistered', 'email_registered', 'first_completed', 
                            'deadline_set','reminder_payment_completed', 'second_completed', 
                            'survey_completed') default 'unregistered',
  subject_deadline_enabled           enum('yes', 'no')   not null,
  first_experimenter_set_deadline   datetime            not null, 
  first_subject_set_deadline        datetime            default null,
  problem_time_limit                time                not null,
  enable_reminder_notification      enum('yes', 'no')   not null,
  reminder_delivery_time            time                default null,
  reminder_cost                     double              default null,
  purchase_reminder                 enum('yes', 'no')   default null,
  game_status			    enum('not_started', 'first_task','outgoing_survey', 'completed') default 'not_started',
  first_task_completed              datetime            default null
) ENGINE=InnoDB;

drop table if exists subject_login_records;
create table subject_login_records(
id					integer auto_increment primary key,
participant_id		integer not null,
login_time			datetime not null
) ENGINE=InnoDB;

drop table if exists new_problem_issued;
create table new_problem_issued(
id					integer auto_increment primary key,
participant_id		integer not null,
task				enum('first') not null,
time_task_issued	datetime not null
) ENGINE=InnoDB;

drop table if exists problem_completion_failure;
create table problem_completion_failure(
id					integer auto_increment primary key,
participant_id		integer not null,
task				enum('first') not null,
date_time			datetime not null
) ENGINE=InnoDB;

drop table if exists survey_answer;
create table survey_answer(
    id              integer auto_increment primary key,
    subject_id      integer not null,
    question_key    varchar(125) not null,
    answer          varchar(255) not null
) ENGINE=InnoDB;

drop table if exists task_log;
create table task_log(
    id              integer auto_increment primary key,
    subject_id      integer not null,
    date_time       datetime not null,
    event           enum( 'login', 'new_problem', 'failed_solution','problem_display', 'completed_solution'),
    task            enum('first_task')
) ENGINE=InnoDB;

drop table if exists email_log;
create table email_log(
    id              integer auto_increment primary key,
    subject_id      integer not null,
    date_time       datetime not null
) ENGINE=InnoDB;
