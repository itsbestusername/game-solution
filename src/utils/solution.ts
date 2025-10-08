export type Step = {
    title: string
    move: null | { from: string; to: string; color?: string; element?: string; count: number }
    flasks: Record<string, string[]>
}

export type SolutionResponse = {
    steps: number
    solution: Record<string, Step>
}

export function stepFlasksToArray(step: Step): string[][] {
    return Object.entries(step.flasks)
        .sort((a, b) => Number(a[0]) - Number(b[0]))
        .map(([, segments]) => segments)
}

export function stepFlaskLabels(step: Step): string[] {
    return Object.keys(step.flasks).sort((a, b) => Number(a) - Number(b))
}


