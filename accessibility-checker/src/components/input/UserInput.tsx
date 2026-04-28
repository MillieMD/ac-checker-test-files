import { useState, ChangeEvent } from "react";

import { v4 as uuidv4 } from 'uuid';

import { Rule, IdentifierTypes, RuleVariants } from "./Rule.js";
import { APIRequestData, RuleData } from "../../api/api.js";


import "./input.css";

type UserInputProps = {
    submit_function : CallableFunction;
}

export function UserInput({submit_function} : UserInputProps) {

    const [url, setUrl] = useState("");
    const [rules, setRules] = useState<Array<RuleData>>([]);

    function handleSubmit(formData : any) {

        const request : APIRequestData = {
            url: url,
            rules: rules
        };

        submit_function(request);
        return false;
        
    }

    function addRule() {
        let key = uuidv4();

        setRules(rules.concat({
            id: key,
            identifier : {
                value : "",
                id_type: IdentifierTypes[0].value 
            },
            relationship: RuleVariants[0].value,
            parameters: {
                identifier_type: IdentifierTypes[0].value
            }

        }));
    }

    function removeRule(targetKey : string) {
        setRules(rules.filter((rule) => rule.id !== targetKey));
    }

    function handleElementIdChange(key : string, e : ChangeEvent<HTMLInputElement>) {

        let index = rules.findIndex(rule => rule.id == key)
        let _rules = [...rules]
        _rules[index].identifier.value = e.target.value
        setRules(_rules)
    }

    function handleElementIdTypeChange(key : string, e: ChangeEvent<HTMLSelectElement>) {
        let index = rules.findIndex(rule => rule.id == key)
        let _rules = [...rules]
        _rules[index].identifier.id_type = e.target.value
        setRules(_rules)
    }

    function handleRelationshipChange(key : string, e: ChangeEvent<HTMLSelectElement>) {
        let index = rules.findIndex(rule => rule.id == key)
        let _rules = [...rules]
        _rules[index].relationship = e.target.value
        _rules[index].parameters = {}
        setRules(_rules)
    }

    function setParameter(key : string, target_param : string, e: ChangeEvent<HTMLInputElement|HTMLSelectElement>) {
        let index = rules.findIndex(rule => rule.id == key)
        let _rules = [...rules]
        _rules[index].parameters[target_param] = e.target.value
        setRules(_rules)
    }

    return (
        <form onSubmit={(e)=>e.preventDefault()} className="card">
            
            <label htmlFor="url-input">Page URL:</label>
            <input type="text" name="url" id="url-input" onChange={(e) => setUrl(e.target.value)}/>

            <div className="rule-container">
                {rules.map((rule : RuleData) =>
                    <div className="rule" key={rule.id}>
                        <Rule id={rule.id}
                            elem_id={{value: rule.identifier.value, on_change: (e) => handleElementIdChange(rule.id, e)}}
                            elem_id_type={{value: rule.identifier.id_type, on_change:(e) => handleElementIdTypeChange(rule.id, e)}}
                            relationship={{value: rule.relationship, on_change: (e) => handleRelationshipChange(rule.id, e)}}
                            parameters={{data : rule.parameters, on_change : setParameter}}
                        />
                        <button type="button" onClick={() => removeRule(rule.id)} className="button button--danger">
                            <i className="fa-solid fa-trash"></i>
                        </button>
                    </div>)}
            </div>

            <div className="flex-row">
                <button type="button" onClick={handleSubmit} className="button button--primary">Check URL</button>
                <button type="button" onClick={addRule} className="button button--secondary"> <i className="fa-solid fa-plus"></i> Add rule</button>
            </div>
        </form>
    )
}