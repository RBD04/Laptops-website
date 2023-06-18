<?php
require_once '../helpers/dbWrapper.php';
require_once '../models/review.php';

function like()
{
    $wrapper = new dbWrapper();
}

function addReview($userId, $productId, $comment, $rating)
{
    $wrapper = new dbWrapper();

    $query = 'INSERT INTO review(userId,productId,comment,rating)
            VALUES("' . $userId . '","' . $productId . '","' . $comment . '","' . $rating . '")';

    $wrapper->executeUpdate($query);
}

function getReviews($productId)
{
    $wrapper = new dbWrapper();

    $query = 'SELECT * 
            FROM review
            WHERE productId="' . $productId . '"';

    $results = $wrapper->executeQuery($query);

    $reviews = [];

    if (!empty($results)) {
        foreach ($results as $item) {
            $review = new Review();
            $review->reviewId = isset($item['reviewId']) ? $item['reviewId'] : null;
            $review->productId = isset($item['productId']) ? $item['productId'] : null;
            $review->userId = isset($item['userId']) ? $item['userId'] : null;
            $review->comment = isset($item['comment']) ? $item['comment'] : null;
            $review->creationDate = isset($item['creationDate']) ? $item['creationDate'] : null;
            $review->likes = isset($item['likes']) ? $item['likes'] : null;
            $review->rating = isset($item['rating']) ? $item['rating'] : null;
            $reviews[] = $review;
        }
        return $reviews;
    }
}
