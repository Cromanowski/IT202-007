
CREATE TABLE IF NOT EXISTS Competitions(
    id int AUTO_INCREMENT PRIMARY KEY,
    comp_name VARCHAR(20),
    duration TIMESTAMP,
    reward int DEFAULT 1,
    starting_reward int,
    join_fee int,
    current_paticipants int,
    min_particpinants int,
    paid_out BOOLEAN default false,
    min_score int default 20,
    first_place_per int default 50,
    second_place_per int default 30,
    third_place_per int default 20,
    reason varchar(20),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)