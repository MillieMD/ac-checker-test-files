import { ChangeEventHandler } from "react";

export type DropdownProps = {
    id : string;
    className : string;
    name : string;
    options : Array<{value : string, label : string}>;
    selected : string;
    onSelect? : ChangeEventHandler<HTMLSelectElement>;
}

export function Dropdown({id, className, name, options, selected, onSelect} : DropdownProps){

    return (
        <select name={name} onChange={onSelect} id={id} defaultValue={selected} className={className}>
            {options.map((option) => 
                <option key={option.value} value={option.value}>{option.label}</option>)
            }
        </select>
    )

}