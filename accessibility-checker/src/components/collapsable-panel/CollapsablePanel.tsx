import { useState, ReactNode } from "react";

import "./collapsable-panel.css";

export type CollapsablePanelProps = {
    id : string;
    title : string;
    content : ReactNode;
    headingLevel? : ("h1" | "h2" | "h3" | "h4" | "h5" | "h6") & keyof React.JSX.IntrinsicElements;
}

export function CollapsablePanel({ title, content, headingLevel="h3"} : CollapsablePanelProps) {

    const [open, setOpen] = useState(false)

    const HeadingTag = headingLevel;

    const panel = (
        <div className="collapsable-panel__content">
            {content}
        </div>
    )

    function toggleAccordion() {
        setOpen(!open);
    }

    return (
        <div className="collapsable-panel">
            <button onClick={toggleAccordion} className="collapsable-panel__button">
                <HeadingTag>{title}</HeadingTag>
            </button>
            {
                open ? panel : null
            }
        </div>
    );
}

