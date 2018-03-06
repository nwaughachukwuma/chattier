import distanceInWordsToNow from 'date-fns/distance_in_words_to_now';

export const ago = (date) => {
    const offset = (new Date()).getTimezoneOffset() * 60000;
    return distanceInWordsToNow(Date.parse(date) - offset) + ' ago';
};
