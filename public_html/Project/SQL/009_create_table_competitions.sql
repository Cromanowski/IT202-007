
CREATE TABLE IF NOT EXISTS Competitions(
    id int AUTO_INCREMENT PRIMARY KEY,
    comp_name VARCHAR(20),
    duration INT,
    reward int DEFAULT 1,
    starting_reward int DEFAULT 1,
    join_fee int DEFAULT 0,
    current_participants int DEFAULT 1,
    min_participants int DEFAULT 3,
    paid_out BOOLEAN default false,
    min_score int default 20,
    first_place_per int default 50,
    second_place_per int default 30,
    third_place_per int default 20,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CHECK(first_place_per + second_place_per + third_place_per = 100)
)