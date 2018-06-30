DROP TABLE IF EXISTS inku-kaehmy_grabbing
DROP TABLE IF EXISTS inku-kaehmy_comment
DROP TABLE IF EXISTS inku-kaehmy_has_comment
DROP TABLE IF EXISTS inku-kaehmy_tag

CREATE TABLE inku-kaehmy_grabbing {
    ID INT NOT NULL,
    userID INT NOT NULL,
    is_hallitus TINYINT NOT NULL,
    grabbing_text VARCHAR(65000) NOT NULL,
    grabbing_title VARCHAR(100) NOT NULL,
    time_stamp DATETIME NOT NULL,
    grabbing_batch VARCHAR(100),
    PRIMARY KEY (ID)
}

CREATE TABLE inku-kaehmy_comment {
    ID INT NOT NULL,
    userID INT NOT NULL,
    comment_text VARCHAR(65000) NOT NULL,
    time_stamp DATETIME NOT NULL,
    depth INT NOT NULL,
    PRIMARY KEY (ID)
}

CREATE TABLE inku-kaehmy_has_comment {
    comment_ID INT NOT NULL,
    parent_grabbing_ID INT,
    parent_comment_ID INT,
    FOREIGN KEY (comment_ID),
    REFERENCES inku-kaehmy_comment(ID),
    FOREIGN KEY (parent_grabbing_ID),
    REFERENCES inku-kaehmy_grabbing(ID)
    FOREIGN KEY (parent_comment_ID),
    REFERENCES inku-kaehmy_comment(ID)
}

CREATE TABLE inku-kaehmy_tag {
    ID INT NOT NULL,
    tag_name_fi VARCHAR(100) NOT NULL,
    tag_name_en VARCHAR(100)
}

CREATE TABLE is_tagged {
    grabbing_ID INT NOT NULL,
    tag_ID INT NOT NULL,
    FOREIGN KEY (grabbing_ID),
    REFERENCES inku-kaehmy_grabbing(ID),
    FOREIGN KEY (tag_ID),
    REFERENCES inku-kaehmy_tag(ID)
}