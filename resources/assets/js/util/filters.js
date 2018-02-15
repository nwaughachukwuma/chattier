import { distanceInWordsToNow } from 'date-fns';

export const ago = (date) => distanceInWordsToNow(date) + ' ago';
