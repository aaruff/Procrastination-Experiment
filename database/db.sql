use pro;

drop table if exists experimenter;

create table experimenter(
  id		integer auto_increment primary key,
  login 	varchar(100) null,
  password 	varchar(40) null
) ENGINE=InnoDB;

drop table if exists session;
create table session(
  id  integer auto_increment primary key,
  size integer not null,
  first_task_deadline datetime not null,
  second_task_deadline datetime not null,
  third_task_deadline datetime not null,
  subject_deadline_enabled boolean not null,
  completion_time_limit time not null,
  penalty double not null,
  payoff integer not null
) Engine=InnoDB;

drop table if exists subject_task_schedule;
create table subject_task_schedule(
  id  integer auto_increment primary key,
  subject_id integer not null,
  task integer not null, # Task IDs {1, 2, 3}
  deadline datetime not null
) Engine=InnoDB;


drop table if exists subject;
create table subject(
  id integer auto_increment primary key,
  login	varchar(100) default null,
  password varchar(100) default null,
  email varchar(100) default null,
  experiment_id	integer not null,
  # unregistered = 1, email registered = 2, first completed = 3, deadline set = 4, reminder payment completed = 5
  # second questionnaire set = 6, survey completed = 7
  survey_status integer not null
) ENGINE=InnoDB;

drop table if exists task_log;
drop table if exists task_log;
create table task_log(
  id					integer auto_increment primary key,
  subject_id		integer not null,
  task_id				integer not null,
  # Event: Issued = 1, Failure = 2, Display Task = 3, Complete Task = 4
  event integer not null,
  date_time       datetime not null
) ENGINE=InnoDB;

drop table if exists survey_answer;
create table survey_answer(
    id integer auto_increment primary key,
    subject_id integer not null,
    type integer not null,
    question integer not null,
    answer varchar(255) not null
) ENGINE=InnoDB;

