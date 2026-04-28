import { CollapsablePanel, CollapsablePanelProps } from "./CollapsablePanel.js";

type CollapsablePanelListProps = {
    id : string;
    items : Array<CollapsablePanelProps>
}

export function CollapsablePanelList({id, items} : CollapsablePanelListProps){

    return(
        <div className="flex-col">
            {
                items.map((item) => 
                    <CollapsablePanel 
                        key={item.id} 
                        id={item.id} 
                        title={item.title} 
                        content={item.content}
                        headingLevel={item.headingLevel ?? undefined}
                    />
                )
            }
        </div>
    )

}