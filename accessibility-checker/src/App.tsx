import { Header } from "./components/header/Header.js"
import { Footer } from "./components/footer/Footer.js"
import { AccessibilityChecker } from "./AccessibilityChecker.js";

import "./index.css";

function App() {
  return (<>
    <Header />
    <main>
      <section>
        <AccessibilityChecker />
      </section>
    </main>
    <Footer />
  </>
  )
}

export default App
