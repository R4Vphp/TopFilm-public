<?php

namespace App\Database;

abstract class SQL {

    const BY_TITLE = "ORDER BY movies.polishTitle";
    const BY_YEAR = "ORDER BY movies.productionYear";
    const BY_DURATION = "ORDER BY movies.duration";
    const BY_RATING = "ORDER BY mentioned.rating";
    const BY_UPLOAD = "ORDER BY movies.uploadAt";

    const ASC = "ASC";
    const DESC = "DESC";

    const SELECT_LISTS = "SELECT * FROM list_headers WHERE userId = :userId ORDER BY createdAt ASC";
    const SELECT_SINGLE_LIST = "SELECT * FROM list_headers WHERE userId = :userId AND id = :listId ORDER BY createdAt ASC";

    const UPDATE_WATCHED =
        "DELETE FROM movie_status WHERE userId = :userId AND movieId = :movieId;
        INSERT INTO
            movie_status(userId, movieId, watched)
            VALUES(:userId, :movieId, :watched);
        DELETE FROM movie_status WHERE watched = 0";
    const UPDATE_RATING =
        "DELETE FROM movie_status WHERE userId = :userId AND movieId = :movieId;
        INSERT INTO
            movie_status(userId, movieId, watched, rating)
            VALUES(:userId, :movieId, 1, :rating)";

    const INSERT_MOVIE = 
        "INSERT INTO 
            movies(id, originalTitle, polishTitle, productionYear, duration, directorID, image, uploadAt)
            VALUES(:id, :orgTitle, :plTitle, :year, :duration, :directorId, :image, :uploadAt)";
    const SELECT_MOVIE =
        "SELECT 
            *, movies.id AS movieId
        FROM 
            directors,
            movies LEFT JOIN (SELECT * FROM movie_status WHERE movie_status.userId = :userId) AS mentioned ON movies.id = mentioned.movieId
        WHERE
            directors.id = movies.directorId AND 
            movies.id = :movieId";

    const INSERT_DIRECTOR = 
        "INSERT INTO 
            directors(firstName, lastName)
            VALUES(:first, :last)";
    const SELECT_DIRECTOR = 
        "SELECT * FROM directors WHERE concat(firstName, ' ', lastName) = :names";

    const INSERT_USER =
        "INSERT INTO 
            users(username, password, createdAt) 
            VALUES(:username, :password, :createdAt)";

    const SELECT_USER = "SELECT * FROM users WHERE username = :username";
    
    const DELETE_REGISTRATION_TOKEN = "DELETE FROM registration_tokens WHERE token = :token";
    const SELECT_USER_WATCHED_TIME = 
        "SELECT 
            sum(movies.duration) AS watchedTime
        FROM 
            movies LEFT JOIN (SELECT * FROM movie_status WHERE movie_status.userId = :userId) AS mentioned ON movies.id = mentioned.movieId
        WHERE
            mentioned.watched = 1";

    const INSERT_LIST_HEADER = 
        "INSERT INTO
            list_headers(userId, title, createdAt)
            VALUES(:userId, :title, :createdAt)";
    const INSERT_LIST_CONTENT =
        "INSERT INTO 
            list_content(movieId, listId)
            VALUES(:movieId, :listId)";

    const DELETE_LIST_CONTENT = "DELETE FROM list_content WHERE listId = :listId AND movieId = :movieId LIMIT 1";

    const SELECT_LIST_OWNER =
        "SELECT * FROM list_headers WHERE id = :listId AND userId = :userId";

    const SELECT_ARCHIVE_QUERY =
        "SELECT 
            *, movies.id AS movieId
        FROM 
            directors,
            movies LEFT JOIN (SELECT * FROM movie_status WHERE movie_status.userId = :userId) AS mentioned ON movies.id = mentioned.movieId
        WHERE
            directors.id = movies.directorId AND
            concat(movies.polishTitle, movies.originalTitle, movies.productionYear, directors.firstName, directors.lastName) LIKE :query
            ";

        const SELECT_USERLIST_QUERY = 
            "SELECT 
                *, movies.id AS movieId
            FROM 
                directors,
                list_content LEFT JOIN movies ON list_content.movieId = movies.id LEFT JOIN (SELECT * FROM movie_status WHERE movie_status.userId = :userId) AS mentioned ON movies.id = mentioned.movieId
            WHERE
                list_content.listId = :listId AND
                directors.id = movies.directorId AND
                concat(movies.polishTitle, movies.originalTitle, movies.productionYear, directors.firstName, directors.lastName) LIKE :query
            ";
        const INSERT_LOGIN = "INSERT INTO logins(userId, ipAddress, occuredAt, succeeded) VALUES(:userId, :ipAddress, :occuredAt, :succeeded)";
        const SELECT_LOGINS = "SELECT * FROM logins WHERE userId = :userId ORDER BY occuredAt DESC LIMIT 100";
}