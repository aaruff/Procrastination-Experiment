use pro;

drop table if exists users;
create table users(
  id		integer auto_increment primary key,
  login 	varchar(100) null,
  password 	varchar(40) null,
  role integer not null # 1 => Subject, 2 => Experimenter
) Engine=InnoDB;

drop table if exists subjects;
create table subjects(
  user_id		integer primary key,
  state integer not null # A subject only plays one game so placing state here will suffice
) ENGINE=InnoDB;

#--
# Each subject has a treatment parameters set for a given session.
#--
drop table if exists treatments;
create table treatments(
  id		integer auto_increment primary key,
  first_task_deadline datetime not null,
  second_task_deadline datetime not null,
  third_task_deadline datetime not null,
  subject_deadline_enabled boolean default false,
  time_limit time not null,
  penalty double not null,
  payoff integer not null
) ENGINE=InnoDB;

drop table if exists task_schedules;
create table task_schedules(
  id  integer auto_increment primary key,
  user_id integer not null,
  task integer not null, # Task IDs {1, 2, 3}
  deadline datetime not null
) Engine=InnoDB;

drop table if exists task_logs;
create table task_logs(
  id					integer auto_increment primary key,
  user_id		integer not null,
  task_id				integer not null,
  # Event: Issued = 1, Failure = 2, Display Task = 3, Complete Task = 4,
  event integer not null,
  date_time       datetime not null
) ENGINE=InnoDB;

#----------------------------------------
# Incoming Survey Tables
#----------------------------------------
drop table if exists incoming_survey_answers;
create table incoming_survey_answers(
  id					integer auto_increment primary key,
  user_id integer not null,
  major varchar(255) not null,
  gpa double not null,
  number_courses integer not null,
  number_clubs integer not null,
  hours_course_work integer not null,
  employed boolean not null,
  hours_work integer default 0,
  hours_social_obligations integer default 0,
  hours_family_obligations integer default 0,
  rank_conscientiousness integer not null,
  rank_assignment_lateness integer not null,
  rank_tardiness integer not null,
  rank_external_distractions integer not null,
  rank_dependability integer not null,
  rank_ability_follow_schedule integer not null,
  rank_ability_organize integer not null,
  rank_ability_pay_attention integer not null,
  certificates_year integer not null,
  temptation integer not null,
  temptation_certificates_year integer not null,
  nights_per_year integer not null
) ENGINE InnoDB;


#----------------------------------------
# Survey Date Time Intervals
#----------------------------------------
drop table if exists survey_datetime_intervals;
create table survey_datetime_intervals(
  id integer auto_increment primary key,
  user_id integer not null,
  type varchar(255) not null,
  start_datetime datetime not null,
  end_datetime datetime not null
) ENGINE=InnoDB;
