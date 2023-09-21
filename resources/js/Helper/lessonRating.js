export const lessonRating = (lesson) => {
    let easeOfUnderstanding = 0;
    let beneficial = 0;
    let goodAtTeaching = 0;
    let enjoyable = 0;

    let countEaseOfUnderstanding = 0;
    let countBeneficial = 0;
    let countGoodAtTeaching = 0;
    let countEnjoyable = 0;

    for (let i = 0; i < lesson.review?.length; i++) {
        if (lesson.review[i].ease_of_understanding) {
            easeOfUnderstanding +=
                lesson.review[i].ease_of_understanding;
            countEaseOfUnderstanding++;
        }
        if (lesson.review[i].beneficial) {
            beneficial += lesson.review[i].beneficial;
            countBeneficial++;
        }
        if (lesson.review[i].good_at_teaching) {
            goodAtTeaching += lesson.review[i].good_at_teaching;
            countGoodAtTeaching++;
        }
        if (lesson.review[i].enjoyable) {
            enjoyable += lesson.review[i].enjoyable;
            countEnjoyable++;
        }
    }
    let easeOfUnderstandingAverage = countEaseOfUnderstanding ? easeOfUnderstanding / countEaseOfUnderstanding : 0
    let beneficialAverage = countBeneficial ? beneficial / countBeneficial : 0
    let goodAtTeachingAverage = countGoodAtTeaching ? goodAtTeaching / countGoodAtTeaching : 0
    let enjoyableAverage = countEnjoyable ? enjoyable / countEnjoyable : 0

    let count = 0
    if (easeOfUnderstandingAverage) {
        count += 1
    }
    if (beneficialAverage) {
        count += 1
    }
    if (goodAtTeachingAverage) {
        count += 1
    }
    if (enjoyableAverage) {
        count += 1
    }

    let totalAverage = count ? ((easeOfUnderstandingAverage + beneficialAverage + goodAtTeachingAverage + enjoyableAverage) / count) : 0

    return totalAverage;
};
