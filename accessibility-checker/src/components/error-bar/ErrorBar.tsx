import "./error-bar.css"

type ErrorBarProps = {
    message : string | null
}

export function ErrorBar({message} : ErrorBarProps) {

    if (message) {
        return (<span className="error-bar">Error: {message}</span>)
    }
}