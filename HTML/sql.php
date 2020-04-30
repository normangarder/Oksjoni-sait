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
    $result = @$stmt->execute(); // ropp escape, aga praegu savi
    return $stmt->insert_id;
}

function deleteAuctionRow(Mysqli $mysqli, $auction_id)
{
    $sql = 'DELETE FROM `auction` where `id` = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $auction_id);
    return $stmt->execute();
}

function addImage(Mysqli $mysqli, $auction_id, $filename) {
    if (!$filename) {
        return null;
    }
    $sql = 'INSERT INTO `image` (`auction_id`, `filename`, `img_order`) VALUES (?, ?, ?);';
    /** @var mysqli_stmt $stmt */
    $stmt = $mysqli->prepare($sql);
    $img_id = 0;
    $stmt->bind_param('isi', $auction_id, $filename, $img_id);
    $result = @$stmt->execute(); // jälle ropp escape
    return $stmt->insert_id;
}

function getAuctions(Mysqli $mysqli) {
    $sql = 'SELECT a.`id`, `title`, `description`, `startingbid`, u.`username` FROM `auction` a LEFT JOIN `users` u ON a.user_id = u.id;';
    /** @var mysqli_stmt $stmt */
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($id, $title, $description, $startingbid, $username);
    $return = [];
    while ($stmt->fetch()) {
        $return[] = [
            'id' => $id,
            'username' => $username,
            'title' => $title,
            'desc' => $description,
            'startingbid' => $startingbid,
        ];
    }
    $stmt->close();
    return $return;
}

function getFirstImageFilenameByAuction(Mysqli $mysqli, $auction_id)
{
    $sql = 'SELECT `filename` FROM `image` i LEFT JOIN `auction` a ON i.auction_id = a.id WHERE a.id = ?;';
    /** @var mysqli_stmt $stmt */
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $auction_id);
    $stmt->execute();
    $stmt->bind_result($image_filename);
    $stmt->fetch();
    return $image_filename;
}

function getAuctionAdded(Mysqli $mysqli, $auction_id)
{
    $sql = 'SELECT `inserted` FROM `auction` a  WHERE a.id = ?;';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $auction_id);
    $stmt->execute();
    $stmt->bind_result($datetime);
    $stmt->fetch();
    return $datetime;
}

function addBidEntry(Mysqli $mysqli, $auction_id, $user_id , $bid_sum)
{
    $sql = 'INSERT INTO `bid` (`auction_id`, `user_id`, `bid`) VALUES (?, ?, ?);';
    /** @var mysqli_stmt $stmt */
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iis', $auction_id, $user_id, $bid_sum);
    $auction_id = (int) $auction_id;
    $user_id = (int) $user_id;
    $bid_sum = (float) $bid_sum;

    $result = @$stmt->execute(); // ropp escape, aga praegu savi
    return $stmt->insert_id;
}
