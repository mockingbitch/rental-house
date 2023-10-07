export const reviewRating = (review) => {
    let totalPoint = review.ease_of_understanding + review.beneficial + review.good_at_teaching + review.enjoyable
    let count = 0

    if (review.ease_of_understanding) {
        count += 1
    }
    if (review.beneficial) {
        count += 1
    }
    if (review.good_at_teaching) {
        count += 1
    }
    if (review.enjoyable) {
        count += 1
    }

    let totalAverage = count ? totalPoint / count : 0
    return totalAverage;
};
