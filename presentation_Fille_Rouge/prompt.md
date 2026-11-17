
---
name: report-to-marp
description: Convert a long report written in Markdown (or a pasted/uploaded .md report, article, study, documentation, or meeting notes) into a short, simple, visual Marp presentation (.md with Marp front-matter, exportable to PPTX/PDF/HTML). Use this skill whenever the user mentions Marp, wants to turn a report/rapport/long markdown/document into slides, a deck, or a presentation in markdown, or asks to "summarize this report as slides" — even if they do not say "Marp" explicitly.
---
 
# Report → Marp presentation
 
Turn a long Markdown report into a **simple, visual, easy-to-present** Marp deck.
The goal is NOT to copy the report into slides. It is to **distill** it: one idea per slide, few words, visuals over paragraphs.
 
## Workflow
 
### 1. Read and map the report
- Read the whole report. Identify: purpose, audience, key findings, numbers, decisions/recommendations, next steps.
- Ignore: methodology details, long justifications, caveats that don't change the message (move them to speaker notes if useful).
- If the audience or language is unclear, assume the same language as the report and a general audience. Don't ask unless truly blocked.
### 2. Plan the storyline (do this before writing slides)
Use this default skeleton, adapted to the content:
 
1. Title slide
2. Context / why this matters (1 slide)
3. Agenda or "3 key takeaways" (optional)
4. Body: one slide per key finding/section (typically 5–10)
5. Recommendations / decisions
6. Next steps
7. Conclusion / thank you / questions
**Size rule:** target ~1 slide per 1–2 pages of report, usually 8–15 slides total. Never exceed 20 unless the user asks.
 
### 3. Write each slide with the "simple" rules
- **One message per slide**; the slide title states the message (e.g. "Revenue grew 24% in Q3", not "Results").
- **Max 5 lines of text**, max ~8 words per bullet. No paragraphs.
- Prefer, in this order: a big number → a table (≤ 5 rows) → a diagram → an image → bullets.
- Put anything extra in speaker notes using `<!-- ... -->` comments.
- Keep numbers exact as in the report; never invent data.
### 4. Make it illustrative
Marp has no built-in chart engine, so use these text-based options (see `references/visual-patterns.md` for copy-paste snippets):
- **Big number / KPI cards** (HTML + CSS classes from the theme)
- **Mermaid diagrams** are NOT rendered by default in Marp CLI — avoid them unless the user says their setup supports it. Use **tables, emoji icons, and CSS columns** instead.
- **Images**: use Marp image syntax `![bg right:40%](url)` only with images the user provided or that exist in the report. Never invent URLs. If no image exists, use emoji or a simple inline SVG.
- **Charts**: if the report has data worth charting, either (a) generate a PNG with matplotlib and reference it, or (b) use an inline SVG bar. Prefer (a) when a code environment is available.
### 5. Output
- Start from `assets/theme.md` (front-matter + CSS). Copy its header into the deck so the output is self-contained.
- Save as `<report-name>-presentation.md` in the outputs folder and present it to the user.
- Slides are separated by `---`.
- After delivering, tell the user in 2–3 lines how to export (see below).
### 6. Quick self-check before delivering
- [ ] Every slide has one clear title and ≤ 5 lines
- [ ] Slide count 8–15 (or justified)
- [ ] No numbers or claims absent from the report
- [ ] Front-matter has `marp: true` and the theme CSS
- [ ] Every `---` separator is on its own line with blank lines around it
## How to export (tell the user)
- **VS Code**: install the extension "Marp for VS Code" → open the file → preview → "Export Slide Deck" (PDF / PPTX / HTML).
- **CLI**: `npx @marp-team/marp-cli deck.md --pptx` (or `--pdf`, `--html`).
- **Online**: paste into https://web.marp.app
## Reference files
- `assets/theme.md` — ready-to-use front-matter + CSS (clean, light, readable). Copy it at the top of every deck.
- `references/visual-patterns.md` — snippets for KPI cards, two columns, timeline, comparison, image-side layouts, speaker notes.
 
