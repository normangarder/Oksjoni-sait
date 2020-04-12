<?php

function getMyId(Mysqli $mysqli) {
    $logged = logged();
    if (!$logged) {
        return null;
    }
    $sql = 'SELECT `id` FROM `users` WHERE `username` = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $logged);
    $stmt->execute();
    return $stmt->get_result();
}

function addAuction(Mysqli $mysqli, $title, $description, $startingbid)
{
    $sql = 'INSERT INTO `auction` (`title`, `description`, `startingbid`, `user_id`) VALUES (?, ?, ?, ?);';
    /** @var mysqli_stmt $stmt */
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssi', $title, $description, $sbid, $user);
    $sbid = (string) $startingbid;
    $user = getMyId($mysqli);
    $foo = @$stmt->execute(); // ropp escape, aga praegu savi
    return $foo;
}

function getAuctions(Mysqli $mysqli) {
    $sql = 'SELECT `title`, `description`, `startingbid`, u.`username` FROM `auction` a LEFT JOIN `users` u ON a.user_id = u.id;';
    /** @var mysqli_stmt $stmt */
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($title, $description, $startingbid, $username);
    $return = [];
    while ($stmt->fetch()) {
        $return[] = [
            'username' => $username,
            'title' => $title,
            'desc' => $description,
            'startingbid' => $startingbid,
        ];
    }
    $stmt->close();
    return $return;
}
