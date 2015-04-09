use pro;

#--
# Users
#--
drop table if exists users;
create table users(
  id		integer auto_increment primary key,
  login 	varchar(100) null,
  password 	varchar(40) null,
  role integer not null # 1 => Subject, 2 => Experimenter
) Engine=InnoDB;

#--
# Subjects
#--
drop table if exists subjects;
create table subjects(
  user_id		integer primary key,
  state integer not null, # A subject only plays one game so placing state here will suffice
  treatment_id integer not null
) ENGINE=InnoDB;

#--
# Treatments: A treatment can consist of varying parameters.
#--
drop table if exists treatments;
create table treatments(
  id		integer auto_increment primary key,
  type integer not null
) ENGINE=InnoDB;

#--
# Tasks: A treatment will assign one or more tasks to each subject.
#--
drop table if exists tasks;
create table tasks(
  id		integer auto_increment primary key,
  number integer not null,
  treatment_id integer not null,
  payoff double not null
) Engine=InnoDB;

#--
# Task Time Limit Parameter: If enabled a subject will have to complete the task in time_limit minutes.
#--
drop table if exists task_time_limits;
create table task_time_limits(
  task_id integer not null,
  time_limit integer default 0 # minutes
) Engine=InnoDB;

#--
# Task Late Penalty Parameter: If enabled a subject will payoff for the task will decrease at a rate of penalty_rate.
#--
drop table if exists task_penalty_rates;
create table task_penalty_rates(
  task_id integer not null,
  penalty_rate double default 0.0
) Engine=InnoDB;

#--
# Task Deadline Parameter: If enabled the task must be completed by the specified date time.
#--
drop table if exists task_deadlines;
create table task_deadlines(
  task_id integer not null,
  deadline datetime not null
) Engine=InnoDB;

#--
# Adjusted Deadline Parameter: If enabled this will contain the subject adjusted deadline for the task.
#--
drop table if exists task_adjusted_deadlines;
create table task_adjusted_deadlines(
  task_id integer not null,
  deadline datetime not null
) Engine=InnoDB;

#--
# Records task submission events
#--
drop table if exists task_submission_logs;
create table task_submission_logs(
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
