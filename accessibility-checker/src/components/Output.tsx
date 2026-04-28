import { CollapsablePanelList } from "./collapsable-panel/CollapsablePanelList.js";

type Page = {
    url : string;
    html : string;
    issues : Array<any>;
}

type OutputProps = {
    pages : Array<Page>;
}

export function Output({ pages } : OutputProps) {

    let num_pages = pages.length
    let total_issues = 0;

    pages.forEach(
        (page) => {
            total_issues += page.issues.length
        }
    )

    if (num_pages > 0) {
        return (
            <output className="flex-col">

                <h2> Results </h2>

                <span> <i className="fa-solid fa-file-circle-check"></i> {num_pages} pages found</span>
                <span> <i className="fa-solid fa-triangle-exclamation"></i> {total_issues} issues found</span>

                {
                    <CollapsablePanelList
                        id="output-list"
                        items={pages.map((page) => {
                            return {
                                id: page.url,
                                title: page.url + " - " + page.issues.length,
                                content: <div className="flex-col">
                                            <iframe srcDoc={page.html} />
                                        </div>
                            }
                        })} />
                }

            </output>
        )
    } else {
        return (
            <>
                <h2> Results </h2>
                <p>No data to display</p>
            </>
        )
    }



}