export type APIRequestData = {
    url : string;
    rules : Array<RuleData>
}

export type RuleData = {
    id : string;
    identifier : {value : string; id_type : string};
    relationship : string;
    parameters : {[key: string]: string;};
}
