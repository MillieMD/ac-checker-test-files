import { ChangeEvent, useState } from "react";
import { ChangeEventHandler } from "react";

import { Dropdown } from "./dropdown/Dropdown.js"
import "./input.css";


export const IdentifierTypes = [
    { label: "element", value: "element" },
    { label: "class", value: "class" },
    { label: "id", value: "id" }
];

export const RuleVariants = [
    { label: "has child", value: "hasChild" },
    { label: "has parent", value: "hasParent" },
    { label: "has attribute", value: "hasAttribute" }
];

type ElementSelectorProps = {
    id: string;
    elem_id: { value: string; on_change?: ChangeEventHandler<HTMLInputElement>};
    elem_id_type: { value: string; on_change?: ChangeEventHandler<HTMLSelectElement>};
}

function ElementSelector({ id, elem_id, elem_id_type }: ElementSelectorProps) {

    let dropdown_id = id + "-type"

    return (
        <>
            <Dropdown id={dropdown_id} name={dropdown_id} options={IdentifierTypes} selected={elem_id_type.value} onSelect={elem_id_type.on_change} className="rule__selector--element-id" />
            <input type="text" name="" id={id + "-name"} onChange={elem_id.on_change} value={elem_id.value} />
        </>

    )
}

export type RuleProps = {
    id: string;
    elem_id: { value: string; on_change?: ChangeEventHandler<HTMLInputElement> };
    elem_id_type: { value: string; on_change?: ChangeEventHandler<HTMLSelectElement> };
    relationship: { value: string; on_change?: ChangeEventHandler<HTMLSelectElement> };
    parameters: { data: any; on_change?: CallableFunction };
}

export function Rule({ id, elem_id, elem_id_type, relationship, parameters }: RuleProps) {

    function handleParameterChange(e: ChangeEvent, target_param: string) {
        if (parameters.on_change) {
            parameters.on_change(id, target_param, e)
        }
    }

    return (
        <>
            <ElementSelector id={id + "-identifier"} elem_id={elem_id} elem_id_type={elem_id_type} />
            <Dropdown name={id + "relationship-selector"} options={RuleVariants} selected={relationship.value} onSelect={relationship.on_change} id={id + "-rule"} className="rule__selector--relationship" />
            {{
                "hasChild": <ElementSelector id={id + "-child"}
                    elem_id={{ value: parameters.data["identifier"], on_change: (e) => handleParameterChange(e, "identifier") }}
                    elem_id_type={{ value: parameters.data["identifier_type"], on_change: (e) => handleParameterChange(e, "identifier_type") }} />,

                "hasParent": <ElementSelector id={id + "-parent"}
                    elem_id={{value: parameters.data["identifier"], on_change: (e) => handleParameterChange(e, "identifier") }}
                    elem_id_type={{value: parameters.data["identifier_type"], on_change: (e) => handleParameterChange(e, "identifier_type") }} />,

                "hasAttribute": <> <input type="text" name="" id={id + "-attribute-name"} value={parameters.data.attribute} onChange={(e) => handleParameterChange(e, "attribute")} />with value<input type="text" name="" id={id + "-attribute-value"} onChange={(e) => handleParameterChange(e, "value")} /> </>
            
            }[relationship.value]}
        </>
    )
}