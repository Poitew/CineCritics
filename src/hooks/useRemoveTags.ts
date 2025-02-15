function useRemoveTags(input: string) {
    return input.replace(/<\/?[^>]+(>|$)/g, ""); // RegEx to remove HTML tags from a string
}

export default useRemoveTags;