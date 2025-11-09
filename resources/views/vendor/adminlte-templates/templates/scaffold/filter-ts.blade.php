
export function getStandardFilterData() {
    return {
        dateTypeFilter: 'C',
        activeFilter: true,
        initialDate: '',//startOfMonth(toCalendarDateTime(today(getLocalTimeZone()))).toString(),
        endDate: '',//endOfMonth(today(getLocalTimeZone())).toString()+'T23:59:59'
    };
}

