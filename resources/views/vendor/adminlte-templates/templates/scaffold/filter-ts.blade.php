import { DateFormatter } from "@@internationalized/date";
import i18n from "@/i18n";

const filterOptions =  {
    dateTypeFilter: {
        C: 'Creation Date',
        U: 'Update Date',
        D: 'Deletion Date',
    },
}

export function getStandardFilterData() {
    return {
        dateTypeFilter: 'C',
        activeFilter: true,
        initialDate: '',//startOfMonth(toCalendarDateTime(today(getLocalTimeZone()))).toString(),
        endDate: '',//endOfMonth(today(getLocalTimeZone())).toString()+'T23:59:59'
    };
}

export function getFilterNames() {
    return {
        dateTypeFilter: 'Data Type',
        activeFilter: 'Only active',
        initialDate: 'Initial Date',
        endDate: 'End Date',
    };
}

export function formatFilterValue(key: string, value: any) {
    switch(key){
        case 'dateTypeFilter':
            return filterOptions.dateTypeFilter[value as keyof typeof filterOptions.dateTypeFilter];
        case 'activeFilter':
            return value === true ? 'Yes' : 'No';
        case 'initialDate':
        case 'endDate':
            const date = new Date(value)
            const df = new DateFormatter(i18n.global.locale.value.replace('_', '-') || 'en-US', {
                dateStyle: "short",
                timeStyle: "medium",
            })
            return df.format(date)
        default:
            return value;
    }
}

export function clearFilter(filterData: any, key: string){
    let standardFilterData = getStandardFilterData();
    filterData[key] = standardFilterData[key as keyof typeof standardFilterData];
}