DROP TABLE IF EXISTS inku_kaehmy_has_comment;
DROP TABLE IF EXISTS inku_kaehmy_is_tagged;
DROP TABLE IF EXISTS inku_kaehmy_tag;
DROP TABLE IF EXISTS inku_kaehmy_grabbing;
DROP TABLE IF EXISTS inku_kaehmy_comment;

CREATE TABLE inku_kaehmy_grabbing (
    ID INT PRIMARY KEY,
    userID INT NOT NULL,
    is_hallitus TINYINT NOT NULL,
    grabbing_text VARCHAR(65000) NOT NULL,
    grabbing_title VARCHAR(100) NOT NULL,
    time_stamp DATETIME NOT NULL,
    grabbing_batch VARCHAR(100)
);

CREATE TABLE inku_kaehmy_comment (
    ID INT PRIMARY KEY,
    userID INT NOT NULL,
    comment_text VARCHAR(65000) NOT NULL,
    time_stamp DATETIME NOT NULL,
    depth INT NOT NULL
);

CREATE TABLE inku_kaehmy_has_comment (
    comment_ID INT NOT NULL,
    parent_grabbing_ID INT,
    parent_comment_ID INT
);

CREATE TABLE inku_kaehmy_tag (
    ID INT NOT NULL,
    tag_name_fi VARCHAR(100) NOT NULL,
    tag_name_en VARCHAR(100),
    PRIMARY KEY (ID)
);

CREATE TABLE inku_kaehmy_is_tagged (
    grabbing_ID INT NOT NULL,
    tag_ID INT NOT NULL
);

ALTER TABLE inku_kaehmy_is_tagged ADD CONSTRAINT istagged_grabbing_id_fk
FOREIGN KEY (grabbing_ID) REFERENCES inku_kaehmy_grabbing (ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE inku_kaehmy_is_tagged ADD CONSTRAINT istagged_tag_id_fk
FOREIGN KEY (tag_ID) REFERENCES inku_kaehmy_tag (ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE inku_kaehmy_has_comment ADD CONSTRAINT hc_comment_id_fk
FOREIGN KEY (comment_ID) REFERENCES inku_kaehmy_comment (ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE inku_kaehmy_has_comment ADD CONSTRAINT hc_comment_parent_g_fk
FOREIGN KEY (parent_grabbing_ID) REFERENCES inku_kaehmy_grabbing (ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE inku_kaehmy_has_comment ADD CONSTRAINT hc_comment_parent_c_fk
FOREIGN KEY (parent_comment_ID) REFERENCES inku_kaehmy_comment (ID)
ON DELETE NO ACTION
ON UPDATE NO ACTION;