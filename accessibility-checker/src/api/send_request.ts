import { APIRequestData } from "./api.js";

const API_URL : string = "http://localhost:8000/check-page";

async function send_request(request : APIRequestData) {

    return fetch(API_URL,
        {
            method: "POST",
            headers: { "Content-Type": "application/json; charset=UTF-8" },
            body: JSON.stringify(request)
        }
    ).then((response) => {
        return response
    }).catch((error) => {
        console.log(error)
        return error
    })

}

export default send_request