import { useState } from "react";

import {UserInput} from "./components/input/UserInput.js";
import {Output} from "./components/Output.js";
import { ErrorBar } from "./components/error-bar/ErrorBar.jsx";

import {APIRequestData} from "./api/api.js"
import send_request from "./api/send_request.js"

export function AccessibilityChecker(){

    const [output, setOutput] = useState([]);
    const [error, setError] = useState(null);

    function handleSubmit(request : APIRequestData){

        send_request(request).then(response => response.json()).then(
            (json) => {

                if (json.status === 200){
                    setError(null);
                    setOutput(json.data.pages);
                    console.log(json.data.pages);

                }else {
                    setError(json.error.message);
                    console.log(json.error)
                    setOutput([]);
                }
            }
        ).catch((e) => console.log(e))

    }

    return (
        <>
            <ErrorBar message={error}/>
            <UserInput submit_function={handleSubmit}/>
            <Output pages={output}/>
        </>
    )

}