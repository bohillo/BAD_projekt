CREATE TABLE UserType (
  idUserType SERIAL,
  name VARCHAR NULL,
  PRIMARY KEY(idUserType)
);

CREATE TABLE Election (
  idElection SERIAL,
  name VARCHAR NULL,
  no_pos INTEGER NULL,
  reg_deadline TIMESTAMP NULL,
  start_time TIMESTAMP NULL,
  end_time TIMESTAMP NULL,
  results_published BOOLEAN NULL,
  PRIMARY KEY(idElection)
);

CREATE TABLE Candidate (
  idCandidate SERIAL,
  idElection INTEGER NOT NULL,
  name VARCHAR NULL,
  surname VARCHAR NULL,
  CONSTRAINT pk_Candidate PRIMARY KEY(idCandidate),
  CONSTRAINT fk_Election FOREIGN KEY(idElection)
  REFERENCES Election(idElection)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE INDEX Candidate_FKIndex1 ON Candidate(idElection);


CREATE TABLE User_ (
  idUser_ SERIAL,
  idUserType INTEGER NULL,
  login VARCHAR NULL,
  pass_hash VARCHAR NULL,
  CONSTRAINT pk_User PRIMARY KEY(idUser_),
  CONSTRAINT fk_UserType FOREIGN KEY(idUserType)
    REFERENCES UserType(idUserType)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE INDEX User__FKIndex1 ON User_(idUserType);



CREATE TABLE Vote (
  idVote SERIAL,
  idUser_ INTEGER NULL,
  idElection INTEGER NULL,
  idCandidate INTEGER NULL,
  time TIMESTAMP NULL,
  CONSTRAINT pk_Vote PRIMARY KEY(idVote),

  CONSTRAINT fk_User_ FOREIGN KEY(idUser_)
    REFERENCES User_(idUser_)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  CONSTRAINT fk_Candidate FOREIGN KEY(idCandidate)
    REFERENCES Candidate(idCandidate)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  CONSTRAINT fk_Election FOREIGN KEY(idElection)
    REFERENCES Election(idElection)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);
