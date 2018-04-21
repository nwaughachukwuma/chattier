import distanceToNow from 'date-fns/distance_in_words_to_now';

export const ago = (date) => {
    return `${distanceToNow(Date.parse(date) - window.utcOffset)} ago`;
};
