import org.apache.commons.cli.*;

public class CommandLineTool {
    public static void main(String[] args) throws ParseException {
        Options options = new Options();
        options.addOption("f", "file", true, "source file");
        CommandLineParser parser = new DefaultParser();
        CommandLine cmd = parser.parse(options, args);
        String fileName = cmd.getOptionValue("f", "");
        System.out.println(fileName);
    }
}
