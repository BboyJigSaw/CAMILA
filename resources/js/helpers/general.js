
import moment from 'moment';

export const spDate = (date) => {
    moment.locale(); 
    return moment(date).format('DD/MM/YYYY');
}
